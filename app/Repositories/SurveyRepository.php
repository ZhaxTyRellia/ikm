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
        $stmt = $this->db->prepare('SELECT * FROM `user` WHERE `username` = ? AND `password` = ? LIMIT 1');
        $stmt->execute([$username, $password]);
        return $stmt->fetch() ?: null;
    }

    public function getAllUsers(): array
    {
        return $this->db->query('SELECT * FROM `user` ORDER BY `id` ASC')->fetchAll();
    }

    public function getUserById(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM `user` WHERE `id` = ? LIMIT 1');
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public function createUser(array $data): bool
    {
        $nextId = (int) $this->db->query('SELECT COALESCE(MAX(`id`), 0) + 1 FROM `user`')->fetchColumn();
        $stmt = $this->db->prepare(
            'INSERT INTO `user` (`id`, `name`, `username`, `password`, `address`, `email`, `mobile`, `role`)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?)'
        );

        return $stmt->execute([
            $nextId,
            $data['name'] ?? '',
            $data['username'] ?? '',
            $data['password'] ?? '',
            $data['address'] ?? '',
            $data['email'] ?? '',
            $data['mobile'] ?? '',
            $data['role'] ?? 'operator',
        ]);
    }

    public function updateUser(int $id, array $data): bool
    {
        $stmt = $this->db->prepare(
            'UPDATE `user`
             SET `name` = ?, `username` = ?, `password` = ?, `address` = ?, `email` = ?, `mobile` = ?, `role` = ?
             WHERE `id` = ?'
        );

        return $stmt->execute([
            $data['name'] ?? '',
            $data['username'] ?? '',
            $data['password'] ?? '',
            $data['address'] ?? '',
            $data['email'] ?? '',
            $data['mobile'] ?? '',
            $data['role'] ?? 'operator',
            $id,
        ]);
    }

    public function deleteUser(int $id): bool
    {
        return $this->db->prepare('DELETE FROM `user` WHERE `id` = ?')->execute([$id]);
    }

    public function getCounterTotals(int $maxCounter = 12): array
    {
        $totals = array_fill(1, $maxCounter, 0);
        $rows = $this->db->query('SELECT `counter`, COUNT(`id_data`) FROM `data` GROUP BY `counter`')
            ->fetchAll(PDO::FETCH_KEY_PAIR);

        foreach ($rows as $counter => $count) {
            $num = (int) $counter;
            if (isset($totals[$num])) {
                $totals[$num] = (int) $count;
            }
        }

        return $totals;
    }

    public function getQuestionsByCounter(string $counter): array
    {
        $stmt = $this->db->prepare('SELECT `id_text`, `text` FROM `question` WHERE `id_text` LIKE ?');
        $stmt->execute(["{$counter}+%"]);
        $byId = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

        $questions = [];
        foreach (self::QUESTION_CODES as $idx => $code) {
            $questions[$idx + 1] = $byId["{$counter}+{$code}"] ?? '';
        }

        return $questions;
    }

    public function updateQuestionsByCounter(string $counter, array $input): void
    {
        $this->db->beginTransaction();
        $stmt = $this->db->prepare(
            'INSERT INTO `question` (`id_text`, `text`) VALUES (?, ?)
             ON DUPLICATE KEY UPDATE `text` = VALUES(`text`)'
        );

        foreach (self::QUESTION_CODES as $idx => $code) {
            $num = $idx + 1;
            if (isset($input["q{$num}"])) {
                $stmt->execute(["{$counter}+{$code}", (string) $input["q{$num}"]]);
            }
        }

        $this->db->commit();
    }

    public function getSurveySummary(string $counter, ?string $awal = null, ?string $akhir = null): array
    {
        $questions = $this->getQuestionsByCounter($counter);
        [$where, $params] = $this->buildFilter($counter, $awal, $akhir);

        $stmt = $this->db->prepare("SELECT `q1`,`q2`,`q3`,`q4`,`q5`,`q6`,`q7`,`q8`,`q9` FROM `data` {$where}");
        $stmt->execute($params);
        $rows = $stmt->fetchAll();

        $defaultCounts = array_fill_keys(array_keys(self::RATING_OPTIONS), 0);
        $summary = [];

        foreach ($questions as $num => $text) {
            $counts = $defaultCounts;
            foreach ($rows as $row) {
                $val = strtolower(trim((string) ($row["q{$num}"] ?? '')));
                if (isset($counts[$val])) {
                    $counts[$val]++;
                }
            }
            $summary[$num] = ['question' => $text, 'counts' => $counts];
        }

        return $summary;
    }

    public function getSuggestions(string $counter, ?string $awal = null, ?string $akhir = null): array
    {
        [$where, $params] = $this->buildFilter($counter, $awal, $akhir, "AND TRIM(`suggestion`) != ''");
        $stmt = $this->db->prepare("SELECT * FROM `data` {$where} ORDER BY `id_data` ASC");
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function insertSurveyResponse(int $userId, string $counter, array $answers): bool
    {
        $stmt = $this->db->prepare(
            'INSERT INTO `data` (`id_user`,`counter`,`q1`,`q2`,`q3`,`q4`,`q5`,`q6`,`q7`,`q8`,`q9`,`suggestion`)
             VALUES (?,?,?,?,?,?,?,?,?,?,?,?)'
        );

        return $stmt->execute([
            $userId,
            $counter,
            $answers['q1'] ?? '',
            $answers['q2'] ?? '',
            $answers['q3'] ?? '',
            $answers['q4'] ?? '',
            $answers['q5'] ?? '',
            $answers['q6'] ?? '',
            $answers['q7'] ?? '',
            $answers['q8'] ?? '',
            $answers['q9'] ?? '',
            $answers['suggestion'] ?? '',
        ]);
    }

    private function buildFilter(string $counter, ?string $awal, ?string $akhir, string $extra = ''): array
    {
        $where = "WHERE `counter` = ? {$extra}";
        $params = [$counter];

        if ($awal && $akhir) {
            $where .= ' AND DATE(`time`) BETWEEN ? AND ?';
            $params[] = $awal;
            $params[] = $akhir;
        }

        return [$where, $params];
    }
}
