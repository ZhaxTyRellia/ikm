<?php

declare(strict_types=1);

namespace App\Repositories;

use PDO;

class SurveyRepository
{
    public const QUESTION_CODES = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i'];

    public const DEFAULT_QUESTIONS = [
        'a' => 'Kesesuaian persyaratan pelayanan dengan jenis pelayananya ?',
        'b' => 'Kemudahan prosedur Pelayanan yang Diberikan penyelenggara pelayanan ?',
        'c' => 'Kecepatan Pelayanan yang Diberikan penyelenggara pelayanan ?',
        'd' => 'Kesesuaian antara biaya yang dibayarkan dengan biaya yang telah ditetapkan ?',
        'e' => 'Kesesuaian antara hasil pelayanan yang diberikan dengan ketentuan yang telah ditetapkan / permintaan awal pelanggan ?',
        'f' => 'Kemampuan petugas dalam memberikan pelayanan ?',
        'g' => 'Sikap (kesopanan dan keramahan) petugas dalam memberikan pelayanan ?',
        'h' => 'kesesuaian antara pelayanan yang didapatkan dengan malumat pelayanan (standart pelayanan) yang ditetapkan ?',
        'i' => 'Penanganan terhadap pengaduan, saran dan masukan ?',
    ];

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

    /**
     * Returns all operator accounts along with their total survey votes (suara rakyat).
     */
    public function getOperatorsWithTotals(): array
    {
        $sql = "SELECT u.*, COUNT(d.`id_data`) AS `total_suara`
                FROM `user` u
                LEFT JOIN `data` d ON d.`counter` = CAST(u.`id` AS CHAR)
                WHERE u.`role` = 'operator'
                GROUP BY u.`id`
                ORDER BY u.`id` ASC";

        return $this->db->query($sql)->fetchAll();
    }

    public function createUser(array $data): bool
    {
        $nextId = (int) $this->db->query('SELECT COALESCE(MAX(`id`), 0) + 1 FROM `user`')->fetchColumn();
        $role = ($data['role'] ?? 'operator') === 'admin' ? 'admin' : 'operator';

        $stmt = $this->db->prepare(
            'INSERT INTO `user` (`id`, `name`, `username`, `password`, `address`, `email`, `mobile`, `photo`, `role`)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)'
        );

        $ok = $stmt->execute([
            $nextId,
            $data['name'] ?? '',
            $data['username'] ?? '',
            $data['password'] ?? '',
            $data['address'] ?? '',
            $data['email'] ?? '',
            $data['mobile'] ?? '',
            $data['photo'] ?? '',
            $role,
        ]);

        if ($ok && $role === 'operator') {
            $this->seedDefaultQuestions((string) $nextId);
        }

        return $ok;
    }

    public function updateUser(int $id, array $data): bool
    {
        $existing = $this->getUserById($id);
        $photo = !empty($data['photo']) ? $data['photo'] : ($existing['photo'] ?? '');

        $stmt = $this->db->prepare(
            'UPDATE `user`
             SET `name` = ?, `username` = ?, `password` = ?, `address` = ?, `email` = ?, `mobile` = ?, `photo` = ?, `role` = ?
             WHERE `id` = ?'
        );

        return $stmt->execute([
            $data['name'] ?? '',
            $data['username'] ?? '',
            $data['password'] ?? '',
            $data['address'] ?? '',
            $data['email'] ?? '',
            $data['mobile'] ?? '',
            $photo,
            ($data['role'] ?? 'operator') === 'admin' ? 'admin' : 'operator',
            $id,
        ]);
    }

    public function deleteUser(int $id): bool
    {
        $this->db->prepare('DELETE FROM `question` WHERE `id_text` LIKE ?')->execute(["{$id}+%"]);
        return $this->db->prepare('DELETE FROM `user` WHERE `id` = ?')->execute([$id]);
    }

    public function seedDefaultQuestions(string $counter): void
    {
        $stmt = $this->db->prepare(
            'INSERT IGNORE INTO `question` (`id_text`, `text`) VALUES (?, ?)'
        );
        foreach (self::DEFAULT_QUESTIONS as $code => $text) {
            $stmt->execute(["{$counter}+{$code}", $text]);
        }
    }

    public function getQuestionsByCounter(string $counter): array
    {
        $stmt = $this->db->prepare('SELECT `id_text`, `text` FROM `question` WHERE `id_text` LIKE ?');
        $stmt->execute(["{$counter}+%"]);
        $byId = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

        $questions = [];
        foreach (self::QUESTION_CODES as $idx => $code) {
            $questions[$idx + 1] = $byId["{$counter}+{$code}"] ?? self::DEFAULT_QUESTIONS[$code];
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
