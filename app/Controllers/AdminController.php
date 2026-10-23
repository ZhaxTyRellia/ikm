<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Repositories\SurveyRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UploadedFileInterface;
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
            'title'      => 'Dashboard Admin',
            'activeMenu' => 'home',
            'isHome'     => true,
            'operators'  => $this->repo->getOperatorsWithTotals(),
        ]);
    }

    public function data(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        return $this->render($response, 'admin/counter_select.php', [
            'title'           => 'Hasil Survey Data',
            'activeMenu'      => 'data',
            'showFooter'      => true,
            'heading'         => 'Hasil Survey Data Per Operator',
            'targetRoute'     => '/admin/data_table?counter=',
            'cardDescription' => 'Lihat rekapitulasi hasil suara rakyat & kritik saran untuk operator ini.',
            'operators'       => $this->repo->getOperatorsWithTotals(),
        ]);
    }

    public function dataTable(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        [$counter, $awal, $akhir] = $this->extractFilterParams($request);
        $operator = $this->repo->getUserById((int) $counter);

        return $this->render($response, 'admin/data_table.php', [
            'title'       => 'Data Survey ' . ($operator['name'] ?? "Operator {$counter}"),
            'activeMenu'  => 'data',
            'counter'     => $counter,
            'operator'    => $operator,
            'awal'        => $awal,
            'akhir'       => $akhir,
            'summary'     => $this->repo->getSurveySummary($counter, $awal ?: null, $akhir ?: null),
            'suggestions' => $this->repo->getSuggestions($counter, $awal ?: null, $akhir ?: null),
        ]);
    }

    public function exportExcel(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        [$counter, $awal, $akhir] = $this->extractFilterParams($request);
        $operator = $this->repo->getUserById((int) $counter);
        $this->view->setLayout('');

        $opName = preg_replace('/[^A-Za-z0-9_-]/', '_', $operator['name'] ?? "Operator_{$counter}");
        $filename = ($awal && $akhir)
            ? "Survey_{$opName}_{$awal}_{$akhir}.xls"
            : "Hasil_Survey_{$opName}.xls";

        return $this->view->render($response, 'admin/export_excel.php', [
            'counter'     => $counter,
            'operator'    => $operator,
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
            'title'           => 'Edit Survey Question',
            'activeMenu'      => 'question',
            'showFooter'      => true,
            'heading'         => 'Edit Pertanyaan Survey Per Operator',
            'targetRoute'     => '/admin/question_table?counter=',
            'cardDescription' => 'Buka untuk melihat dan mengubah daftar pertanyaan indeks kepuasan operator ini.',
            'operators'       => $this->repo->getOperatorsWithTotals(),
        ]);
    }

    public function questionTable(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $counter = (string) ($request->getQueryParams()['counter'] ?? '1');
        $operator = $this->repo->getUserById((int) $counter);

        return $this->render($response, 'admin/question_table.php', [
            'title'      => 'Edit Pertanyaan ' . ($operator['name'] ?? "Operator {$counter}"),
            'activeMenu' => 'question',
            'counter'    => $counter,
            'operator'   => $operator,
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
            'title'      => 'Account List',
            'activeMenu' => 'account',
            'showFooter' => true,
            'users'      => $this->repo->getAllUsers(),
        ]);
    }

    public function accountAddForm(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        return $this->render($response, 'admin/account_form.php', [
            'title'      => 'Tambah Akun / Target Operator',
            'activeMenu' => 'account',
            'isEdit'     => false,
            'account'    => [],
        ]);
    }

    public function accountCreate(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = (array) ($request->getParsedBody() ?? []);
        $uploadedPhoto = $this->handlePhotoUpload($request);
        if ($uploadedPhoto !== null) {
            $data['photo'] = $uploadedPhoto;
        }

        try {
            if ($this->repo->createUser($data)) {
                return $this->redirect($response, '/admin/account');
            }
        } catch (\Throwable) {
        }

        return $this->alertRedirect($response, 'Gagal membuat akun! Pastikan username belum digunakan.', '/admin/account_add');
    }

    public function accountEditForm(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $id = (int) ($request->getQueryParams()['id'] ?? -1);
        $account = $this->repo->getUserById($id);

        if (!$account) {
            return $this->redirect($response, '/admin/account');
        }

        return $this->render($response, 'admin/account_form.php', [
            'title'      => 'Edit Akun / Identitas Operator',
            'activeMenu' => 'account',
            'isEdit'     => true,
            'account'    => $account,
        ]);
    }

    public function accountUpdate(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = (array) ($request->getParsedBody() ?? []);
        $id = (int) trim((string) ($data['id'] ?? '0'));

        $uploadedPhoto = $this->handlePhotoUpload($request);
        if ($uploadedPhoto !== null) {
            $data['photo'] = $uploadedPhoto;
        }

        try {
            if ($this->repo->updateUser($id, $data)) {
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

    private function handlePhotoUpload(ServerRequestInterface $request): ?string
    {
        $files = $request->getUploadedFiles();
        /** @var UploadedFileInterface|null $photo */
        $photo = $files['photo'] ?? null;

        if (!$photo || $photo->getError() !== UPLOAD_ERR_OK) {
            return null;
        }

        $ext = strtolower(pathinfo($photo->getClientFilename() ?? '', PATHINFO_EXTENSION));
        if (!in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'], true)) {
            $ext = 'png';
        }

        $uploadDir = __DIR__ . '/../../public/images/operators';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0775, true);
        }

        $filename = 'op_' . uniqid('', true) . '.' . $ext;
        $photo->moveTo($uploadDir . DIRECTORY_SEPARATOR . $filename);

        return 'images/operators/' . $filename;
    }

    private function render(ResponseInterface $response, string $template, array $data = []): ResponseInterface
    {
        $data['isAdmin'] = true;
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
