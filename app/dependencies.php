<?php

declare(strict_types=1);

use App\Repositories\SurveyRepository;
use Slim\Views\PhpRenderer;

return static fn(string $basePath): array => [
    'basePath' => $basePath,

    PDO::class => static function (): PDO {
        $host = getenv('DB_HOST') ?: 'localhost';
        $db   = getenv('DB_NAME') ?: 'ikm';
        $user = getenv('DB_USER') ?: 'root';
        $pass = getenv('DB_PASS') !== false ? getenv('DB_PASS') : '';

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        $pdo = new PDO("mysql:host={$host};charset=utf8mb4", $user, $pass, $options);

        // Check if database and core tables exist; if not, auto-import ikm.sql migration & seed
        $dbExists = (bool) $pdo->query(
            'SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = ' . $pdo->quote($db)
        )->fetchColumn();

        if (!$dbExists) {
            SurveyRepository::importSqlFile($pdo, __DIR__ . '/../ikm.sql');
        }

        $pdo->exec('USE `' . str_replace('`', '``', $db) . '`');

        $tableCount = (int) $pdo->query(
            'SELECT COUNT(*) FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = ' . $pdo->quote($db)
            . " AND TABLE_NAME IN ('user', 'question', 'data', 'settings')"
        )->fetchColumn();

        if ($tableCount < 4) {
            SurveyRepository::importSqlFile($pdo, __DIR__ . '/../ikm.sql');
            $pdo->exec('USE `' . str_replace('`', '``', $db) . '`');
        }

        return $pdo;
    },

    PhpRenderer::class => static fn(): PhpRenderer => new PhpRenderer(
        __DIR__ . '/../views',
        ['basePath' => $basePath]
    ),
];
