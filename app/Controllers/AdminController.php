<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Repositories\SurveyRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\PhpRenderer;

class AdminController
{
    public function __construct(
        private readonly PhpRenderer $view,
        private readonly SurveyRepository $repo
    ) {
    }

    public function home(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        return $this->render($response, 'admin/home.php', [
            'title'      => 'Dashboard',
            'activeMenu' => 'home',
            'isHome'     => true,
            'counters'   => $this->repo->getCounterTotals(12),
        ]);
    }

    public function data(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        return $this->render($response, 'admin/counter_select.php', [
            'title'           => 'Dashboard',
            'activeMenu'      => 'data',
            'showFooter'      => true,
            'heading'         => 'Hasil Survey Data',
            'targetRoute'     => '/admin/data_table?counter=1',
            'cardTitle'       => 'operator 1',
            'cardDescription' => 'Hasil data survey dalam lingkup menyeluruh,<br />Buka untuk melihat hasil survey skala global.',
        ]);
    }

    public function dataTable(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        [$counter, $awal, $akhir] = $this->extractFilterParams($request);

        return $this->render($response, 'admin/data_table.php', [
            'title'       => "Data Survey {$counter}",
            'activeMenu'  => 'data',
            'counter'     => $counter,
            'awal'        => $awal,
            'akhir'       => $akhir,
            'summary'     => $this->repo->getSurveySummary($counter, $awal ?: null, $akhir ?: null),
            'suggestions' => $this->repo->getSuggestions($counter, $awal ?: null, $akhir ?: null),
        ]);
    }

    public function exportExcel(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        [$counter, $awal, $akhir] = $this->extractFilterParams($request);
        $this->view->setLayout('');

        $filename = ($awal && $akhir)
            ? "survey_Operator{$counter}_{$awal}_{$akhir}.xls"
            : "Hasil Survey Counter {$counter}.xls";

        return $this->view->render($response, 'admin/export_excel.php', [
            'counter'     => $counter,
            'summary'     => $this->repo->getSurveySummary($counter, $awal ?: null, $akhir ?: null),
            'questions'   => $this->repo->getQuestionsByCounter($counter),
            'suggestions' => $this->repo->getSuggestions($counter, $awal ?: null, $akhir ?: null),
        ])
            ->withHeader('Content-Type', 'application/vnd.ms-excel; charset=UTF-8')
            ->withHeader('Content-Disposition', "attachment; filename=\"{$filename}\"");
    }

    public function question(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        return $this->render($response, 'admin/counter_select.php', [
            'title'           => 'Dashboard',
            'activeMenu'      => 'question',
            'showFooter'      => true,
            'heading'         => 'Edit Survey Question',
            'targetRoute'     => '/admin/question_table?counter=1',
            'cardTitle'       => 'Operator 1',
            'cardDescription' => 'Buka untuk melihat dan merubah pertanyaan pada pilihan indeks kepuasan',
        ]);
    }

    public function questionTable(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $counter = (string) ($request->getQueryParams()['counter'] ?? '1');

        return $this->render($response, 'admin/question_table.php', [
            'title'      => "Edit Question Survey {$counter}",
            'activeMenu' => 'question',
            'counter'    => $counter,
            'questions'  => $this->repo->getQuestionsByCounter($counter),
        ]);
    }

    public function questionEdit(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $body = (array) ($request->getParsedBody() ?? []);
        $counter = (string) ($body['counter'] ?? $request->getQueryParams()['counter'] ?? '1');
        $this->repo->updateQuestionsByCounter($counter, $body);

        return $this->redirect($response, '/admin/question');
    }

    public function account(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        return $this->render($response, 'admin/account.php', [
            'title'      => 'Dashboard',
            'activeMenu' => 'account',
            'showFooter' => true,
            'users'      => $this->repo->getAllUsers(),
        ]);
    }

    public function accountAddForm(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        return $this->render($response, 'admin/account_form.php', [
            'title'      => 'Add Account',
            'activeMenu' => 'account',
            'isEdit'     => false,
            'account'    => [],
        ]);
    }

    public function accountCreate(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        try {
            if ($this->repo->createUser((array) ($request->getParsedBody() ?? []))) {
                return $this->redirect($response, '/admin/account');
            }
        } catch (\Throwable) {
        }

        return $this->alertRedirect($response, 'account failed to create !!!', '/admin/account_add');
    }

    public function accountEditForm(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $id = (int) ($request->getQueryParams()['id'] ?? -1);
        $account = $this->repo->getUserById($id);

        if (!$account) {
            return $this->redirect($response, '/admin/account');
        }

        return $this->render($response, 'admin/account_form.php', [
            'title'      => 'Edit Account',
            'activeMenu' => 'account',
            'isEdit'     => true,
            'account'    => $account,
        ]);
    }

    public function accountUpdate(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $body = (array) ($request->getParsedBody() ?? []);
        $id = (int) trim((string) ($body['id'] ?? '0'));

        try {
            if ($this->repo->updateUser($id, $body)) {
                return $this->alertRedirect($response, 'Success to Change data', '/admin/account');
            }
        } catch (\Throwable) {
        }

        return $this->alertRedirect($response, 'The something is wrong !!!', '/admin/account_edit?id=' . $id);
    }

    public function accountDelete(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $id = $request->getQueryParams()['id'] ?? null;
        if ($id !== null) {
            $this->repo->deleteUser((int) $id);
        }

        return $this->redirect($response, '/admin/account');
    }

    private function render(ResponseInterface $response, string $template, array $data = []): ResponseInterface
    {
        $this->view->setLayout('layouts/admin.php');
        return $this->view->render($response, $template, $data);
    }

    private function extractFilterParams(ServerRequestInterface $request): array
    {
        $q = $request->getQueryParams();
        $b = (array) ($request->getParsedBody() ?? []);

        return [
            (string) ($q['counter'] ?? $b['counter'] ?? '1'),
            trim((string) ($b['awal'] ?? $q['awal'] ?? '')),
            trim((string) ($b['akhir'] ?? $q['akhir'] ?? '')),
        ];
    }

    private function redirect(ResponseInterface $response, string $path): ResponseInterface
    {
        $basePath = (string) ($this->view->getAttribute('basePath') ?? '');
        return $response->withHeader('Location', ($basePath . $path) ?: '/')->withStatus(302);
    }

    private function alertRedirect(ResponseInterface $response, string $msg, string $path): ResponseInterface
    {
        $basePath = (string) ($this->view->getAttribute('basePath') ?? '');
        $url = ($basePath . $path) ?: '/';
        $response->getBody()->write(sprintf(
            '<script>alert(%s);window.location.href=%s;</script>',
            json_encode($msg),
            json_encode($url)
        ));
        return $response->withHeader('Content-Type', 'text/html; charset=UTF-8');
    }
}
