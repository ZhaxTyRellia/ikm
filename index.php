<?php

declare(strict_types=1);

use App\Config\Database;
use App\Controllers\AdminController;
use App\Controllers\AuthController;
use App\Controllers\OperatorController;
use App\Repositories\SurveyRepository;
use Slim\Factory\AppFactory;
use Slim\Views\PhpRenderer;

require __DIR__ . '/vendor/autoload.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$app = AppFactory::create();

// Automatically detect subdirectory basePath if hosted under a subfolder
$scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? ''));
$basePath = ($scriptDir !== '/' && $scriptDir !== '.') ? rtrim($scriptDir, '/') : '';
if ($basePath !== '') {
    $app->setBasePath($basePath);
}

$app->addBodyParsingMiddleware();
$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, true, true);

$pdo = Database::getConnection();
$repository = new SurveyRepository($pdo);
$renderer = new PhpRenderer(__DIR__ . '/views');

$authController = new AuthController($renderer, $repository, $basePath);
$adminController = new AdminController($renderer, $repository, $basePath);
$operatorController = new OperatorController($renderer, $repository, $basePath);

$registerRoutes = require __DIR__ . '/app/routes.php';
$registerRoutes($app, $authController, $adminController, $operatorController, $basePath);

$app->run();
