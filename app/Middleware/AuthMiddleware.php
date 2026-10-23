<?php

declare(strict_types=1);

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Response;

class AuthMiddleware implements MiddlewareInterface
{
    public function __construct(
        private readonly string $requiredRole,
        private readonly string $basePath = ''
    ) {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $isLoggedIn = !empty($_SESSION['islogin']);
        $role = $_SESSION['role'] ?? '';

        if (!$isLoggedIn || $role !== $this->requiredRole) {
            $response = new Response();
            $target = $this->basePath . ($isLoggedIn ? '/logout' : '/');
            return $response
                ->withHeader('Location', $target !== '' ? $target : '/')
                ->withStatus(302);
        }

        return $handler->handle($request);
    }
}
