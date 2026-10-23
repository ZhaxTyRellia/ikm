<?php

declare(strict_types=1);

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AuthController extends Controller
{
    public function showLogin(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        if (!empty($_SESSION['islogin'])) {
            if (($_SESSION['role'] ?? '') === 'admin') {
                return $this->redirect($response, '/admin/home');
            }
            if (($_SESSION['role'] ?? '') === 'operator') {
                return $this->redirect($response, '/operator/survey');
            }
        }

        return $this->render($response, 'auth/login.php', [
            'error' => '',
        ]);
    }

    public function login(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $body = (array) ($request->getParsedBody() ?? []);
        $username = trim((string) ($body['username'] ?? ''));
        $password = (string) ($body['password'] ?? '');

        $user = $this->repo->findUserByCredentials($username, $password);

        if ($user === null) {
            return $this->render($response, 'auth/login.php', [
                'error' => 'Username or Password wrong !!!',
            ]);
        }

        $_SESSION['islogin'] = true;
        $_SESSION['username'] = $user['username'];
        $_SESSION['id'] = (int) $user['id'];
        $_SESSION['role'] = $user['role'];

        if ($user['role'] === 'admin') {
            return $this->redirect($response, '/admin/home');
        }

        if ($user['role'] === 'operator') {
            return $this->redirect($response, '/operator/survey');
        }

        return $this->render($response, 'auth/login.php', [
            'error' => 'Account is not Approve !!!',
        ]);
    }

    public function logout(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $_SESSION = [];
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }

        return $this->redirect($response, '/');
    }
}
