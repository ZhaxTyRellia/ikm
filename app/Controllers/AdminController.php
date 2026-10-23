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
        return $this->render($response, [
            'title'      => 'Dashboard Management Admin',
            'activeMenu' => 'home',
            'section'    => 'dashboard',
            'operators'  => $this->repo->getOperatorsWithTotals(),
        ]);
    }

    public function data(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        return $this->home($request, $response);
    }

    public function dataTable(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        [$counter, $awal, $akhir] = $this->extractFilterParams($request);
        $operator = $this->repo->getUserById((int) $counter);

        return $this->render($response, [
            'title'       => 'Data Survey ' . ($operator['name'] ?? "Operator {$counter}"),
            'activeMenu'  => 'data',
            'section'     => 'data',
            'counter'     => $counter,
            'operator'    => $operator,
            'questions'   => $this->repo->getQuestionsByCounter($counter),
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

        $opName = preg_replace('/[^A-Za-z0-9_-]/', '_', $operator['name'] ?? "Operator_{$counter}");
        $filename = ($awal && $akhir)
            ? "Survey_{$opName}_{$awal}_{$akhir}.xls"
            : "Hasil_Survey_{$opName}.xls";

        return $this->view->render($response, 'admin.php', [
            'section'     => 'export',
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
        return $this->home($request, $response);
    }

    public function questionTable(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $counter = (string) ($request->getQueryParams()['counter'] ?? '1');
        $operator = $this->repo->getUserById((int) $counter);

        return $this->render($response, [
            'title'            => 'Atur Pertanyaan ' . ($operator['name'] ?? "Operator {$counter}"),
            'activeMenu'       => 'question',
            'section'          => 'question',
            'counter'          => $counter,
            'operator'         => $operator,
            'questions'        => $this->repo->getQuestionsByCounter($counter),
            'defaultQuestions' => SurveyRepository::DEFAULT_QUESTIONS,
        ]);
    }

    public function questionEdit(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $body = (array) ($request->getParsedBody() ?? []);
        $counter = (string) ($body['counter'] ?? $request->getQueryParams()['counter'] ?? '1');
        $this->repo->updateQuestionsByCounter($counter, $body);

        return $this->alertRedirect($response, 'Daftar pertanyaan operator berhasil disimpan!', '/admin/home');
    }

    public function account(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        return $this->render($response, [
            'title'      => 'Management Operator & Admin',
            'activeMenu' => 'account',
            'section'    => 'account_list',
            'users'      => $this->repo->getAllUsers(),
        ]);
    }

    public function accountAddForm(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        return $this->render($response, [
            'title'      => 'Tambah Target Operator / Admin',
            'activeMenu' => 'account',
            'section'    => 'account_form',
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
                return $this->redirect($response, '/admin/home');
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
            return $this->redirect($response, '/admin/home');
        }

        return $this->render($response, [
            'title'      => 'Edit Identitas Operator / Admin',
            'activeMenu' => 'account',
            'section'    => 'account_form',
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
                return $this->alertRedirect($response, 'Data identitas berhasil diperbarui!', '/admin/home');
            }
        } catch (\Throwable) {
        }

        return $this->alertRedirect($response, 'Gagal memperbarui data!', '/admin/account_edit?id=' . $id);
    }

    public function accountDelete(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $id = $request->getQueryParams()['id'] ?? null;
        if ($id !== null) {
            $this->repo->deleteUser((int) $id);
        }

        return $this->redirect($response, '/admin/home');
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

    private function render(ResponseInterface $response, array $data = []): ResponseInterface
    {
        $data['isAdmin'] = true;
        return $this->view->render($response, 'admin.php', $data);
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
