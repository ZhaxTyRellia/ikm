<?php

declare(strict_types=1);

use DI\ContainerBuilder;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? ''));
$requestUri = $_SERVER['REQUEST_URI'] ?? '';
if (str_ends_with($scriptDir, '/public') && !str_starts_with($requestUri, $scriptDir)) {
    $scriptDir = substr($scriptDir, 0, -7);
}
$basePath = ($scriptDir !== '/' && $scriptDir !== '.') ? rtrim($scriptDir, '/') : '';

$builder = new ContainerBuilder();
$builder->addDefinitions((require __DIR__ . '/../app/dependencies.php')($basePath));
$container = $builder->build();

$app = AppFactory::createFromContainer($container);
if ($basePath !== '') {
    $app->setBasePath($basePath);
}

$app->addBodyParsingMiddleware();
$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, true, true);

(require __DIR__ . '/../app/routes.php')($app);

$app->run();
