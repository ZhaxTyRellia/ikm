<?php

declare(strict_types=1);

namespace App\Repositories;

use PDO;

class SurveyRepository
{
    public const QUESTION_CODES = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i'];

    public const RATING_OPTIONS = [
        'tidak puas'  => 'sgt-tdk-puas.gif',
        'kurang puas' => 'tidak-puas.gif',
        'puas'        => 'puas.gif',
        'sangat puas' => 'sangat-puas.gif',
    ];

    public function __construct(private readonly PDO $db)
    {
    }

    public function findUserByCredentials(string $username, string $password): ?array
    {
        $stmt = $this->db->prepare(
            'SELECT * FROM `user` WHERE `username` = :username AND `password` = :password LIMIT 1'
        );
        $stmt->execute([
            'username' => $username,
            'password' => $password,
        ]);

        $user = $stmt->fetch();
        return $user !== false ? $user : null;
    }

    public function getAllUsers(): array
    {
        $stmt = $this->db->query('SELECT * FROM `user` ORDER BY `id` ASC');
        return $stmt->fetchAll();
    }

    public function getUserById(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM `user` WHERE `id` = :id LIMIT 1');
        $stmt->execute(['id' => $id]);
        $user = $stmt->fetch();
        return $user !== false ? $user : null;
    }

    public function createUser(array $data): bool
    {
        $nextIdStmt = $this->db->query('SELECT COALESCE(MAX(`id`), 0) + 1 FROM `user`');
        $nextId = (int) $nextIdStmt->fetchColumn();

        $stmt = $this->db->prepare(
            'INSERT INTO `user` (`id`, `name`, `username`, `password`, `address`, `email`, `mobile`, `role`)
             VALUES (:id, :name, :username, :password, :address, :email, :mobile, :role)'
        );

        return $stmt->execute([
            'id'       => $nextId,
            'name'     => $data['name'] ?? '',
            'username' => $data['username'] ?? '',
            'password' => $data['password'] ?? '',
            'address'  => $data['address'] ?? '',
            'email'    => $data['email'] ?? '',
            'mobile'   => $data['mobile'] ?? '',
            'role'     => $data['role'] ?? 'operator',
        ]);
    }

    public function updateUser(int $id, array $data): bool
    {
        $stmt = $this->db->prepare(
            'UPDATE `user`
             SET `name` = :name,
                 `username` = :username,
                 `password` = :password,
                 `address` = :address,
                 `email` = :email,
                 `mobile` = :mobile,
                 `role` = :role
             WHERE `id` = :id'
        );

        return $stmt->execute([
            'id'       => $id,
            'name'     => $data['name'] ?? '',
            'username' => $data['username'] ?? '',
            'password' => $data['password'] ?? '',
            'address'  => $data['address'] ?? '',
            'email'    => $data['email'] ?? '',
            'mobile'   => $data['mobile'] ?? '',
            'role'     => $data['role'] ?? 'operator',
        ]);
    }

    public function deleteUser(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM `user` WHERE `id` = :id');
        return $stmt->execute(['id' => $id]);
    }

    /**
     * Returns survey response counts indexed by counter number (1..$maxCounter).
     *
     * @return array<int, int>
     */
    public function getCounterTotals(int $maxCounter = 12): array
    {
        $totals = array_fill(1, $maxCounter, 0);

        $stmt = $this->db->query(
            'SELECT `counter`, COUNT(`id_data`) AS `jumlah` FROM `data` GROUP BY `counter`'
        );

        foreach ($stmt->fetchAll() as $row) {
            $counterNum = (int) $row['counter'];
            if ($counterNum >= 1 && $counterNum <= $maxCounter) {
                $totals[$counterNum] = (int) $row['jumlah'];
            }
        }

        return $totals;
    }

    /**
     * Returns the 9 questions for a counter indexed 1..9.
     *
     * @return array<int, string>
     */
    public function getQuestionsByCounter(string $counter): array
    {
        $ids = array_map(
            static fn(string $code): string => "{$counter}+{$code}",
            self::QUESTION_CODES
        );

        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $stmt = $this->db->prepare(
            "SELECT `id_text`, `text` FROM `question` WHERE `id_text` IN ({$placeholders})"
        );
        $stmt->execute($ids);

        $byId = [];
        foreach ($stmt->fetchAll() as $row) {
            $byId[$row['id_text']] = $row['text'];
        }

        $questions = [];
        foreach (self::QUESTION_CODES as $index => $code) {
            $num = $index + 1;
            $key = "{$counter}+{$code}";
            $questions[$num] = $byId[$key] ?? '';
        }

        return $questions;
    }

    /**
     * Updates all 9 questions (q1..q9) for a given counter inside a transaction.
     */
    public function updateQuestionsByCounter(string $counter, array $input): bool
    {
        $this->db->beginTransaction();

        try {
            $stmt = $this->db->prepare(
                'INSERT INTO `question` (`id_text`, `text`)
                 VALUES (:id_text, :text)
                 ON DUPLICATE KEY UPDATE `text` = VALUES(`text`)'
            );

            foreach (self::QUESTION_CODES as $index => $code) {
                $num = $index + 1;
                $field = "q{$num}";
                if (isset($input[$field])) {
                    $stmt->execute([
                        'id_text' => "{$counter}+{$code}",
                        'text'    => (string) $input[$field],
                    ]);
                }
            }

            return $this->db->commit();
        } catch (\Throwable $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    /**
     * Returns summary counts per question (1..9) across all rating options.
     *
     * @return array<int, array{question: string, counts: array<string, int>}>
     */
    public function getSurveySummary(string $counter, ?string $awal = null, ?string $akhir = null): array
    {
        $questions = $this->getQuestionsByCounter($counter);
        $ratings = array_keys(self::RATING_OPTIONS);

        $where = 'WHERE `counter` = :counter';
        $params = ['counter' => $counter];

        if ($awal !== null && $awal !== '' && $akhir !== null && $akhir !== '') {
            $where .= ' AND DATE(`time`) BETWEEN :awal AND :akhir';
            $params['awal'] = $awal;
            $params['akhir'] = $akhir;
        }

        $stmt = $this->db->prepare(
            "SELECT `q1`, `q2`, `q3`, `q4`, `q5`, `q6`, `q7`, `q8`, `q9` FROM `data` {$where}"
        );
        $stmt->execute($params);
        $rows = $stmt->fetchAll();

        $summary = [];
        for ($i = 1; $i <= count(self::QUESTION_CODES); $i++) {
            $counts = array_fill_keys($ratings, 0);
            $col = "q{$i}";

            foreach ($rows as $row) {
                $val = strtolower(trim((string) ($row[$col] ?? '')));
                if (isset($counts[$val])) {
                    $counts[$val]++;
                }
            }

            $summary[$i] = [
                'question' => $questions[$i] ?? '',
                'counts'   => $counts,
            ];
        }

        return $summary;
    }

    /**
     * Returns all non-empty suggestions for a counter, optionally filtered by date range.
     */
    public function getSuggestions(string $counter, ?string $awal = null, ?string $akhir = null): array
    {
        $where = "WHERE `counter` = :counter AND TRIM(`suggestion`) != ''";
        $params = ['counter' => $counter];

        if ($awal !== null && $awal !== '' && $akhir !== null && $akhir !== '') {
            $where .= ' AND DATE(`time`) BETWEEN :awal AND :akhir';
            $params['awal'] = $awal;
            $params['akhir'] = $akhir;
        }

        $stmt = $this->db->prepare(
            "SELECT * FROM `data` {$where} ORDER BY `id_data` ASC"
        );
        $stmt->execute($params);

        return $stmt->fetchAll();
    }

    public function insertSurveyResponse(int $userId, string $counter, array $answers): bool
    {
        $stmt = $this->db->prepare(
            'INSERT INTO `data`
             (`id_user`, `counter`, `q1`, `q2`, `q3`, `q4`, `q5`, `q6`, `q7`, `q8`, `q9`, `suggestion`)
             VALUES (:id_user, :counter, :q1, :q2, :q3, :q4, :q5, :q6, :q7, :q8, :q9, :suggestion)'
        );

        return $stmt->execute([
            'id_user'    => $userId,
            'counter'    => $counter,
            'q1'         => $answers['q1'] ?? '',
            'q2'         => $answers['q2'] ?? '',
            'q3'         => $answers['q3'] ?? '',
            'q4'         => $answers['q4'] ?? '',
            'q5'         => $answers['q5'] ?? '',
            'q6'         => $answers['q6'] ?? '',
            'q7'         => $answers['q7'] ?? '',
            'q8'         => $answers['q8'] ?? '',
            'q9'         => $answers['q9'] ?? '',
            'suggestion' => $answers['suggestion'] ?? '',
        ]);
    }
}
