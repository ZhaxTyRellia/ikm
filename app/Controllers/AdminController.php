<?php

declare(strict_types=1);

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AdminController extends Controller
{
    public function home(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $counters = $this->repo->getCounterTotals(12);

        return $this->render($response, 'admin/home.php', [
            'title'      => 'Dashboard',
            'activeMenu' => 'home',
            'isHome'     => true,
            'showFooter' => false,
            'counters'   => $counters,
        ]);
    }

    public function data(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        return $this->render($response, 'admin/counter_select.php', [
            'title'           => 'Dashboard',
            'activeMenu'      => 'data',
            'isHome'          => false,
            'showFooter'      => true,
            'heading'         => 'Hasil Survey Data',
            'targetRoute'     => '/admin/data_table?counter=1',
            'cardTitle'       => 'operator 1',
            'cardDescription' => 'Hasil data survey dalam lingkup menyeluruh,<br />Buka untuk melihat hasil survey skala global.',
        ]);
    }

    public function dataTable(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $query = $request->getQueryParams();
        $body = (array) ($request->getParsedBody() ?? []);

        $counter = (string) ($query['counter'] ?? $body['counter'] ?? '1');
        $awal = trim((string) ($body['awal'] ?? $query['awal'] ?? ''));
        $akhir = trim((string) ($body['akhir'] ?? $query['akhir'] ?? ''));

        $summary = $this->repo->getSurveySummary($counter, $awal ?: null, $akhir ?: null);
        $suggestions = $this->repo->getSuggestions($counter, $awal ?: null, $akhir ?: null);

        return $this->render($response, 'admin/data_table.php', [
            'title'       => "Data Survey {$counter}",
            'activeMenu'  => 'data',
            'isHome'      => false,
            'showFooter'  => false,
            'counter'     => $counter,
            'awal'        => $awal,
            'akhir'       => $akhir,
            'summary'     => $summary,
            'suggestions' => $suggestions,
        ]);
    }

    public function exportExcel(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $query = $request->getQueryParams();
        $body = (array) ($request->getParsedBody() ?? []);

        $counter = (string) ($query['counter'] ?? $body['counter'] ?? '1');
        $awal = trim((string) ($query['awal'] ?? $body['awal'] ?? ''));
        $akhir = trim((string) ($query['akhir'] ?? $body['akhir'] ?? ''));

        $summary = $this->repo->getSurveySummary($counter, $awal ?: null, $akhir ?: null);
        $questions = $this->repo->getQuestionsByCounter($counter);
        $suggestions = $this->repo->getSuggestions($counter, $awal ?: null, $akhir ?: null);

        $filename = ($awal !== '' && $akhir !== '')
            ? "survey_Operator{$counter}_{$awal}_{$akhir}.xls"
            : "Hasil Survey Counter {$counter}.xls";

        $rendered = $this->render($response, 'admin/export_excel.php', [
            'counter'     => $counter,
            'awal'        => $awal,
            'akhir'       => $akhir,
            'summary'     => $summary,
            'questions'   => $questions,
            'suggestions' => $suggestions,
        ]);

        return $rendered
            ->withHeader('Content-Type', 'application/vnd.ms-excel; charset=UTF-8')
            ->withHeader('Content-Disposition', "attachment; filename=\"{$filename}\"");
    }

    public function question(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        return $this->render($response, 'admin/counter_select.php', [
            'title'           => 'Dashboard',
            'activeMenu'      => 'question',
            'isHome'          => false,
            'showFooter'      => true,
            'heading'         => 'Edit Survey Question',
            'targetRoute'     => '/admin/question_table?counter=1',
            'cardTitle'       => 'Operator 1',
            'cardDescription' => 'Buka untuk melihat dan merubah pertanyaan pada pilihan indeks kepuasan',
        ]);
    }

    public function questionTable(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $query = $request->getQueryParams();
        $counter = (string) ($query['counter'] ?? '1');
        $questions = $this->repo->getQuestionsByCounter($counter);

        return $this->render($response, 'admin/question_table.php', [
            'title'      => "Edit Question Survey {$counter}",
            'activeMenu' => 'question',
            'isHome'     => false,
            'showFooter' => false,
            'counter'    => $counter,
            'questions'  => $questions,
        ]);
    }

    public function questionEdit(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $query = $request->getQueryParams();
        $body = (array) ($request->getParsedBody() ?? []);
        $counter = (string) ($body['counter'] ?? $query['counter'] ?? '1');

        $this->repo->updateQuestionsByCounter($counter, $body);

        return $this->redirect($response, '/admin/question');
    }

    public function account(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $users = $this->repo->getAllUsers();

        return $this->render($response, 'admin/account.php', [
            'title'      => 'Dashboard',
            'activeMenu' => 'account',
            'isHome'     => false,
            'showFooter' => true,
            'users'      => $users,
        ]);
    }

    public function accountAddForm(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        return $this->render($response, 'admin/account_form.php', [
            'title'      => 'Add Account',
            'activeMenu' => 'account',
            'isHome'     => false,
            'showFooter' => false,
            'isEdit'     => false,
            'account'    => [
                'id'       => '',
                'name'     => '',
                'username' => '',
                'password' => '',
                'address'  => '',
                'email'    => '',
                'mobile'   => '',
                'role'     => '',
            ],
        ]);
    }

    public function accountCreate(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $body = (array) ($request->getParsedBody() ?? []);

        try {
            $ok = $this->repo->createUser($body);
            if ($ok) {
                return $this->redirect($response, '/admin/account');
            }
        } catch (\Throwable) {
            // Fall through to failure alert
        }

        return $this->alertAndRedirect($response, 'account failed to create !!!', '/admin/account_add');
    }

    public function accountEditForm(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $query = $request->getQueryParams();
        $id = isset($query['id']) ? (int) $query['id'] : -1;
        $account = $this->repo->getUserById($id);

        if ($account === null) {
            return $this->redirect($response, '/admin/account');
        }

        return $this->render($response, 'admin/account_form.php', [
            'title'      => 'Edit Account',
            'activeMenu' => 'account',
            'isHome'     => false,
            'showFooter' => false,
            'isEdit'     => true,
            'account'    => $account,
        ]);
    }

    public function accountUpdate(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $body = (array) ($request->getParsedBody() ?? []);
        $id = (int) trim((string) ($body['id'] ?? '0'));

        try {
            $ok = $this->repo->updateUser($id, $body);
            if ($ok) {
                return $this->alertAndRedirect($response, 'Success to Change data', '/admin/account');
            }
        } catch (\Throwable) {
            // Fall through to error alert
        }

        return $this->alertAndRedirect($response, 'The something is wrong !!!', '/admin/account_edit?id=' . $id);
    }

    public function accountDelete(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $query = $request->getQueryParams();
        if (isset($query['id'])) {
            $this->repo->deleteUser((int) $query['id']);
        }

        return $this->redirect($response, '/admin/account');
    }
}
