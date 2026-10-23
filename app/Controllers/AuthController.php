<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Repositories\SurveyRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\PhpRenderer;

class AuthController
{
    public function __construct(
        private readonly PhpRenderer $view,
        private readonly SurveyRepository $repo
    ) {
    }

    public function home(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $this->view->setLayout('');

        return $this->view->render($response, 'public_home.php', [
            'isAdmin'    => !empty($_SESSION['islogin']) && ($_SESSION['role'] ?? '') === 'admin',
            'loginError' => '',
            'operators'  => $this->repo->getOperatorsWithTotals(),
        ]);
    }

    public function login(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $body = (array) ($request->getParsedBody() ?? []);
        $user = $this->repo->findUserByCredentials(
            trim((string) ($body['username'] ?? '')),
            (string) ($body['password'] ?? '')
        );

        if (!$user || ($user['role'] ?? '') !== 'admin') {
            $this->view->setLayout('');
            return $this->view->render($response, 'public_home.php', [
                'isAdmin'    => false,
                'loginError' => !$user ? 'Username atau Password salah!' : 'Login hanya untuk Admin!',
                'operators'  => $this->repo->getOperatorsWithTotals(),
            ]);
        }

        $_SESSION['islogin']  = true;
        $_SESSION['username'] = $user['username'];
        $_SESSION['id']       = (int) $user['id'];
        $_SESSION['role']     = $user['role'];

        return $this->redirect($response, '/admin/home');
    }

    public function logout(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $_SESSION = [];
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }

        return $this->redirect($response, '/');
    }

    private function redirect(ResponseInterface $response, string $path): ResponseInterface
    {
        $basePath = (string) ($this->view->getAttribute('basePath') ?? '');
        return $response->withHeader('Location', ($basePath . $path) ?: '/')->withStatus(302);
    }
}
