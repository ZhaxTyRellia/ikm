<?php

declare(strict_types=1);

use App\Controllers\AdminController;
use App\Controllers\AuthController;
use App\Controllers\OperatorController;
use App\Middleware\AuthMiddleware;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return static function (App $app): void {
    // Auth Routes
    $app->get('/', [AuthController::class, 'showLogin'])->setName('login');
    $app->post('/', [AuthController::class, 'login']);
    $app->get('/index', [AuthController::class, 'showLogin']);
    $app->get('/login', [AuthController::class, 'showLogin']);
    $app->post('/login', [AuthController::class, 'login']);
    $app->map(['GET', 'POST'], '/logout', [AuthController::class, 'logout'])->setName('logout');

    // Admin Routes
    $app->group('/admin', function (RouteCollectorProxy $group): void {
        $group->get('[/]', [AdminController::class, 'home']);
        $group->get('/home', [AdminController::class, 'home'])->setName('admin.home');

        $group->get('/data', [AdminController::class, 'data'])->setName('admin.data');
        $group->map(['GET', 'POST'], '/data_table', [AdminController::class, 'dataTable'])->setName('admin.data_table');
        $group->map(['GET', 'POST'], '/search', [AdminController::class, 'dataTable']);
        $group->map(['GET', 'POST'], '/excel/export', [AdminController::class, 'exportExcel'])->setName('admin.export');
        $group->map(['GET', 'POST'], '/excel/export_search', [AdminController::class, 'exportExcel']);
        $group->map(['GET', 'POST'], '/export_search', [AdminController::class, 'exportExcel']);

        $group->get('/question', [AdminController::class, 'question'])->setName('admin.question');
        $group->get('/question_table', [AdminController::class, 'questionTable'])->setName('admin.question_table');
        $group->post('/question_edit', [AdminController::class, 'questionEdit']);

        $group->get('/account', [AdminController::class, 'account'])->setName('admin.account');
        $group->get('/account_add', [AdminController::class, 'accountAddForm']);
        $group->post('/account_add', [AdminController::class, 'accountCreate']);
        $group->get('/account_edit', [AdminController::class, 'accountEditForm']);
        $group->post('/account_edit', [AdminController::class, 'accountUpdate']);
        $group->map(['GET', 'POST'], '/account_delete', [AdminController::class, 'accountDelete']);
    })->add(new AuthMiddleware('admin'));

    // Operator Routes
    $app->group('/operator', function (RouteCollectorProxy $group): void {
        $group->get('[/]', [OperatorController::class, 'survey']);
        $group->get('/survey', [OperatorController::class, 'survey'])->setName('operator.survey');
        $group->post('/survey', [OperatorController::class, 'submitSurvey']);
    })->add(new AuthMiddleware('operator'));
};
