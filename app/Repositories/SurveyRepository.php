<?php

declare(strict_types=1);

namespace App\Repositories;

use PDO;

class SurveyRepository
{
    public const MAX_QUESTIONS = 10;

    public const DEFAULT_QUESTIONS = [
        1  => 'Bagaimana kesesuaian persyaratan pelayanan dengan jenis pelayanannya?',
        2  => 'Bagaimana kemudahan prosedur pelayanan yang diberikan petugas?',
        3  => 'Bagaimana kecepatan waktu petugas dalam memberikan pelayanan?',
        4  => 'Bagaimana sikap (kesopanan dan keramahan) petugas saat melayani Anda?',
        5  => 'Bagaimana kesesuaian biaya pelayanan dengan ketentuan yang ditetapkan?',
        6  => 'Bagaimana kesesuaian hasil pelayanan dengan standar yang ditetapkan?',
        7  => 'Bagaimana kemampuan dan kompetensi petugas dalam memberikan pelayanan?',
        8  => 'Bagaimana kejelasan informasi dan maklumat pelayanan yang disampaikan?',
        9  => 'Bagaimana kecepatan penanganan pengaduan, saran, dan masukan?',
        10 => 'Bagaimana kenyamanan sarana dan prasarana di area pelayanan?',
    ];

    public const RATING_OPTIONS = [
        'tidak puas'  => 'sgt-tdk-puas.gif',
        'kurang puas' => 'tidak-puas.gif',
        'puas'        => 'puas.gif',
        'sangat puas' => 'sangat-puas.gif',
    ];

    public const RATING_SCORES = [
        'tidak puas'  => 1,
        'kurang puas' => 2,
        'puas'        => 3,
        'sangat puas' => 4,
    ];

    public function __construct(private readonly PDO $db)
    {
    }

    /**
     * Imports and executes the migration & seed SQL file (ikm.sql).
     */
    public static function importSqlFile(PDO $pdo, string $sqlFilePath): void
    {
        if (!is_file($sqlFilePath)) {
            return;
        }

        $sql = (string) file_get_contents($sqlFilePath);
        $lines = preg_split('/\r\n|\r|\n/', $sql) ?: [];
        $cleanLines = [];

        foreach ($lines as $line) {
            $trimmed = trim($line);
            if ($trimmed === '' || str_starts_with($trimmed, '--')) {
                continue;
            }
            $cleanLines[] = $line;
        }

        $cleanSql = implode("\n", $cleanLines);
        $statements = preg_split('/;\s*(\n|$)/', $cleanSql) ?: [];

        foreach ($statements as $statement) {
            $stmt = trim($statement);
            if ($stmt !== '') {
                $pdo->exec($stmt);
            }
        }
    }

    /**
     * Resets the database back to a fresh initial state using ikm.sql migration & seed.
     */
    public function resetDatabase(): void
    {
        self::importSqlFile($this->db, __DIR__ . '/../../ikm.sql');
    }

    /**
     * Returns site-wide settings (company logo, marquee text, footer text).
     *
     * @return array{company_logo: string, marquee_text: string, footer_text: string}
     */
    public function getSettings(): array
    {
        $defaults = [
            'company_logo' => 'images/logo.png',
            'marquee_text' => 'Terima kasih atas partisipasi, penilaian, dan masukan Anda bagi peningkatan pelayanan kami.',
            'footer_text'  => 'Portal Survei IKM & Suara Rakyat',
        ];

        try {
            $rows = $this->db->query('SELECT `setting_key`, `setting_value` FROM `settings`')->fetchAll(PDO::FETCH_KEY_PAIR);
        } catch (\Throwable) {
            $this->ensureSettingsTable($defaults);
            $rows = [];
        }

        return [
            'company_logo' => !empty($rows['company_logo']) ? (string) $rows['company_logo'] : $defaults['company_logo'],
            'marquee_text' => isset($rows['marquee_text']) && trim((string) $rows['marquee_text']) !== ''
                ? (string) $rows['marquee_text']
                : $defaults['marquee_text'],
            'footer_text'  => isset($rows['footer_text']) && trim((string) $rows['footer_text']) !== ''
                ? (string) $rows['footer_text']
                : $defaults['footer_text'],
        ];
    }

    public function updateSettings(array $data): void
    {
        $current = $this->getSettings();
        $this->ensureSettingsTable($current);

        $stmt = $this->db->prepare(
            'INSERT INTO `settings` (`setting_key`, `setting_value`) VALUES (?, ?)
             ON DUPLICATE KEY UPDATE `setting_value` = VALUES(`setting_value`)'
        );

        foreach (['company_logo', 'marquee_text', 'footer_text'] as $key) {
            if (isset($data[$key]) && trim((string) $data[$key]) !== '') {
                $stmt->execute([$key, trim((string) $data[$key])]);
            }
        }
    }

    private function ensureSettingsTable(array $defaults): void
    {
        $this->db->exec(
            'CREATE TABLE IF NOT EXISTS `settings` (
                `setting_key` varchar(50) NOT NULL,
                `setting_value` text NOT NULL,
                PRIMARY KEY (`setting_key`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci'
        );
        $stmt = $this->db->prepare('INSERT IGNORE INTO `settings` (`setting_key`, `setting_value`) VALUES (?, ?)');
        foreach ($defaults as $k => $v) {
            $stmt->execute([$k, $v]);
        }
    }

    public function findUserByCredentials(string $username, string $password): ?array
    {
        if ($username === '' || $password === '') {
            return null;
        }
        $stmt = $this->db->prepare(
            "SELECT * FROM `user` WHERE `username` = ? AND `password` = ? AND `role` = 'admin' LIMIT 1"
        );
        $stmt->execute([$username, $password]);
        return $stmt->fetch() ?: null;
    }

    public function getUserById(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM `user` WHERE `id` = ? LIMIT 1');
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    /**
     * Returns all operators enriched with question count, survey count, accumulated star rating (0-5), and service status.
     */
    public function getOperatorsWithTotals(): array
    {
        $operators = $this->db->query(
            "SELECT * FROM `user` WHERE `role` = 'operator' ORDER BY `id` ASC"
        )->fetchAll();

        $qCounts = $this->db->query(
            'SELECT `id_user`, COUNT(`id_question`) FROM `question` GROUP BY `id_user`'
        )->fetchAll(PDO::FETCH_KEY_PAIR);

        $allDataStmt = $this->db->query(
            'SELECT `counter`, `q1`,`q2`,`q3`,`q4`,`q5`,`q6`,`q7`,`q8`,`q9`,`q10` FROM `data`'
        );
        $dataByCounter = [];
        foreach ($allDataStmt->fetchAll() as $row) {
            $dataByCounter[(string) $row['counter']][] = $row;
        }

        foreach ($operators as &$op) {
            $id = (int) $op['id'];
            $rows = $dataByCounter[(string) $id] ?? [];
            $totalSuara = count($rows);

            $totalScore = 0;
            $answeredCount = 0;
            foreach ($rows as $r) {
                for ($i = 1; $i <= self::MAX_QUESTIONS; $i++) {
                    $ans = strtolower(trim((string) ($r["q{$i}"] ?? '')));
                    if (isset(self::RATING_SCORES[$ans])) {
                        $totalScore += self::RATING_SCORES[$ans];
                        $answeredCount++;
                    }
                }
            }

            // Convert 1..4 scale to 1.25..5.00 star scale
            $starRating = $answeredCount > 0 ? round(($totalScore / ($answeredCount * 4)) * 5, 1) : 0.0;

            [$statusLabel, $statusClass] = match (true) {
                $totalSuara === 0   => ['Belum Dinilai', 'secondary'],
                $starRating >= 4.2  => ['Sangat Baik', 'success'],
                $starRating >= 3.2  => ['Layanan Baik', 'info'],
                $starRating >= 2.2  => ['Kurang Baik', 'warning'],
                default             => ['Layanan Buruk', 'danger'],
            };

            $op['question_count'] = (int) ($qCounts[$id] ?? 4);
            $op['total_suara']    = $totalSuara;
            $op['star_rating']    = $starRating;
            $op['stars_filled']   = (int) round($starRating);
            $op['status_label']   = $statusLabel;
            $op['status_class']   = $statusClass;
        }
        unset($op);

        return $operators;
    }

    public function createUser(array $data): bool
    {
        $nextId = (int) $this->db->query('SELECT COALESCE(MAX(`id`), 0) + 1 FROM `user`')->fetchColumn();

        $stmt = $this->db->prepare(
            "INSERT INTO `user` (`id`, `name`, `username`, `password`, `address`, `email`, `mobile`, `photo`, `role`)
             VALUES (?, ?, '', '', ?, ?, ?, ?, 'operator')"
        );

        $ok = $stmt->execute([
            $nextId,
            trim((string) ($data['name'] ?? '')),
            trim((string) ($data['address'] ?? '')),
            trim((string) ($data['email'] ?? '')),
            trim((string) ($data['mobile'] ?? '')),
            $data['photo'] ?? '',
        ]);

        if ($ok) {
            $initialCount = max(1, min(self::MAX_QUESTIONS, (int) ($data['question_count'] ?? 4)));
            $this->seedDefaultQuestions($nextId, $initialCount);
        }

        return $ok;
    }

    public function updateUser(int $id, array $data): bool
    {
        $existing = $this->getUserById($id);
        $photo = !empty($data['photo']) ? $data['photo'] : ($existing['photo'] ?? '');

        $stmt = $this->db->prepare(
            'UPDATE `user`
             SET `name` = ?, `address` = ?, `email` = ?, `mobile` = ?, `photo` = ?
             WHERE `id` = ?'
        );

        return $stmt->execute([
            trim((string) ($data['name'] ?? '')),
            trim((string) ($data['address'] ?? '')),
            trim((string) ($data['email'] ?? '')),
            trim((string) ($data['mobile'] ?? '')),
            $photo,
            $id,
        ]);
    }

    public function deleteUser(int $id): bool
    {
        $this->db->prepare('DELETE FROM `question` WHERE `id_user` = ?')->execute([$id]);
        $this->db->prepare('DELETE FROM `data` WHERE `counter` = ?')->execute([(string) $id]);
        return $this->db->prepare('DELETE FROM `user` WHERE `id` = ?')->execute([$id]);
    }

    public function seedDefaultQuestions(int $operatorId, int $count = 4): void
    {
        $count = max(1, min(self::MAX_QUESTIONS, $count));
        $stmt = $this->db->prepare(
            'INSERT IGNORE INTO `question` (`id_user`, `q_order`, `text`) VALUES (?, ?, ?)'
        );
        for ($i = 1; $i <= $count; $i++) {
            $stmt->execute([$operatorId, $i, self::DEFAULT_QUESTIONS[$i]]);
        }
    }

    /**
     * Returns active questions for an operator (1..N, where 1 <= N <= 10).
     *
     * @return array<int, string>
     */
    public function getQuestionsByCounter(string $counter): array
    {
        $operatorId = (int) $counter;
        $stmt = $this->db->prepare(
            'SELECT `q_order`, `text` FROM `question` WHERE `id_user` = ? ORDER BY `q_order` ASC LIMIT 10'
        );
        $stmt->execute([$operatorId]);
        $questions = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

        if (empty($questions)) {
            $this->seedDefaultQuestions($operatorId, 4);
            $stmt->execute([$operatorId]);
            $questions = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
        }

        // Re-index 1..N cleanly
        $result = [];
        $num = 1;
        foreach ($questions as $text) {
            if ($num <= self::MAX_QUESTIONS) {
                $result[$num++] = (string) $text;
            }
        }

        return $result;
    }

    /**
     * Saves 1..10 dynamic questions for an operator.
     */
    public function updateQuestionsByCounter(string $counter, array $input): void
    {
        $operatorId = (int) $counter;
        $questions = [];
        $maxCount = isset($input['question_count'])
            ? max(1, min(self::MAX_QUESTIONS, (int) $input['question_count']))
            : self::MAX_QUESTIONS;

        if (isset($input['questions']) && is_array($input['questions'])) {
            for ($i = 1; $i <= $maxCount; $i++) {
                $trimmed = trim((string) ($input['questions'][$i] ?? ''));
                if ($trimmed !== '') {
                    $questions[] = $trimmed;
                }
            }
        } else {
            for ($i = 1; $i <= $maxCount; $i++) {
                $trimmed = trim((string) ($input["q{$i}"] ?? ''));
                if ($trimmed !== '') {
                    $questions[] = $trimmed;
                }
            }
        }

        if (empty($questions)) {
            $questions[] = self::DEFAULT_QUESTIONS[1];
        }

        $questions = array_slice($questions, 0, self::MAX_QUESTIONS);

        $this->db->beginTransaction();
        $this->db->prepare('DELETE FROM `question` WHERE `id_user` = ?')->execute([$operatorId]);

        $stmt = $this->db->prepare(
            'INSERT INTO `question` (`id_user`, `q_order`, `text`) VALUES (?, ?, ?)'
        );
        foreach ($questions as $idx => $text) {
            $stmt->execute([$operatorId, $idx + 1, $text]);
        }

        $this->db->commit();
    }

    public function getSurveySummary(string $counter, ?string $awal = null, ?string $akhir = null): array
    {
        $questions = $this->getQuestionsByCounter($counter);
        [$where, $params] = $this->buildFilter($counter, $awal, $akhir);

        $stmt = $this->db->prepare(
            "SELECT `q1`,`q2`,`q3`,`q4`,`q5`,`q6`,`q7`,`q8`,`q9`,`q10` FROM `data` {$where}"
        );
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

    /**
     * Returns all survey responses & feedback notes (including skipped feedback) for an operator.
     */
    public function getSuggestions(string $counter, ?string $awal = null, ?string $akhir = null): array
    {
        [$where, $params] = $this->buildFilter($counter, $awal, $akhir);
        $stmt = $this->db->prepare("SELECT * FROM `data` {$where} ORDER BY `id_data` DESC");
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function insertSurveyResponse(int $userId, string $counter, array $answers): bool
    {
        $stmt = $this->db->prepare(
            'INSERT INTO `data` (`id_user`,`counter`,`q1`,`q2`,`q3`,`q4`,`q5`,`q6`,`q7`,`q8`,`q9`,`q10`,`suggestion`)
             VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)'
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
            $answers['q10'] ?? '',
            trim((string) ($answers['suggestion'] ?? '')),
        ]);
    }

    private function buildFilter(string $counter, ?string $awal, ?string $akhir): array
    {
        $where = 'WHERE `counter` = ?';
        $params = [$counter];

        if ($awal && $akhir) {
            $where .= ' AND DATE(`time`) BETWEEN ? AND ?';
            $params[] = $awal;
            $params[] = $akhir;
        }

        return [$where, $params];
    }
}
