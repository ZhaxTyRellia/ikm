<?php

declare(strict_types=1);

use Slim\Views\PhpRenderer;

return static fn(string $basePath): array => [
    'basePath' => $basePath,

    PDO::class => static function (): PDO {
        $host = getenv('DB_HOST') ?: 'localhost';
        $db   = getenv('DB_NAME') ?: 'ikm';
        $user = getenv('DB_USER') ?: 'root';
        $pass = getenv('DB_PASS') !== false ? getenv('DB_PASS') : '';

        return new PDO("mysql:host={$host};dbname={$db};charset=utf8mb4", $user, $pass, [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]);
    },

    PhpRenderer::class => static fn(): PhpRenderer => new PhpRenderer(
        __DIR__ . '/../views',
        ['basePath' => $basePath]
    ),
];
