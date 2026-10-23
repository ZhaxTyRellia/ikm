<?php

declare(strict_types=1);

use App\Controllers\AdminController;
use App\Controllers\AuthController;
use App\Controllers\OperatorController;
use App\Middleware\AuthMiddleware;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return static function (
    App $app,
    AuthController $authController,
    AdminController $adminController,
    OperatorController $operatorController,
    string $basePath
): void {
    // Authentication Routes
    $app->get('/', [$authController, 'showLogin']);
    $app->post('/', [$authController, 'login']);
    $app->get('/index', [$authController, 'showLogin']);
    $app->get('/login', [$authController, 'showLogin']);
    $app->post('/login', [$authController, 'login']);
    $app->map(['GET', 'POST'], '/logout', [$authController, 'logout']);

    // Admin Routes
    $app->group('/admin', function (RouteCollectorProxy $group) use ($adminController): void {
        $group->get('', [$adminController, 'home']);
        $group->get('/', [$adminController, 'home']);
        $group->get('/home', [$adminController, 'home']);

        // Survey Data & Search & Export
        $group->get('/data', [$adminController, 'data']);
        $group->map(['GET', 'POST'], '/data_table', [$adminController, 'dataTable']);
        $group->map(['GET', 'POST'], '/search', [$adminController, 'dataTable']);
        $group->map(['GET', 'POST'], '/excel/export', [$adminController, 'exportExcel']);
        $group->map(['GET', 'POST'], '/excel/export_search', [$adminController, 'exportExcel']);
        $group->map(['GET', 'POST'], '/export_search', [$adminController, 'exportExcel']);

        // Survey Questions
        $group->get('/question', [$adminController, 'question']);
        $group->get('/question_table', [$adminController, 'questionTable']);
        $group->post('/question_edit', [$adminController, 'questionEdit']);

        // User Accounts
        $group->get('/account', [$adminController, 'account']);
        $group->get('/account_add', [$adminController, 'accountAddForm']);
        $group->post('/account_add', [$adminController, 'accountCreate']);
        $group->get('/account_edit', [$adminController, 'accountEditForm']);
        $group->post('/account_edit', [$adminController, 'accountUpdate']);
        $group->map(['GET', 'POST'], '/account_delete', [$adminController, 'accountDelete']);
    })->add(new AuthMiddleware('admin', $basePath));

    // Operator Routes
    $app->group('/operator', function (RouteCollectorProxy $group) use ($operatorController): void {
        $group->get('', [$operatorController, 'survey']);
        $group->get('/', [$operatorController, 'survey']);
        $group->get('/survey', [$operatorController, 'survey']);
        $group->post('/survey', [$operatorController, 'submitSurvey']);
    })->add(new AuthMiddleware('operator', $basePath));
};
