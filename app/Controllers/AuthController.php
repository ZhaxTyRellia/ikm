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

    public function showLogin(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        if (!empty($_SESSION['islogin'])) {
            $role = $_SESSION['role'] ?? '';
            if ($role === 'admin') {
                return $this->redirect($response, '/admin/home');
            }
            if ($role === 'operator') {
                return $this->redirect($response, '/operator/survey');
            }
        }

        return $this->view->render($response, 'auth/login.php', ['error' => '']);
    }

    public function login(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $body = (array) ($request->getParsedBody() ?? []);
        $user = $this->repo->findUserByCredentials(
            trim((string) ($body['username'] ?? '')),
            (string) ($body['password'] ?? '')
        );

        if (!$user) {
            return $this->view->render($response, 'auth/login.php', [
                'error' => 'Username or Password wrong !!!',
            ]);
        }

        $_SESSION['islogin']  = true;
        $_SESSION['username'] = $user['username'];
        $_SESSION['id']       = (int) $user['id'];
        $_SESSION['role']     = $user['role'];

        return match ($user['role']) {
            'admin'    => $this->redirect($response, '/admin/home'),
            'operator' => $this->redirect($response, '/operator/survey'),
            default    => $this->view->render($response, 'auth/login.php', [
                'error' => 'Account is not Approve !!!',
            ]),
        };
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
