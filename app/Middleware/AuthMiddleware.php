<?php

declare(strict_types=1);

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Response;
use Slim\Routing\RouteContext;

class AuthMiddleware implements MiddlewareInterface
{
    public function __construct(private readonly string $requiredRole)
    {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $isLoggedIn = !empty($_SESSION['islogin']);
        $role = $_SESSION['role'] ?? '';

        if (!$isLoggedIn || $role !== $this->requiredRole) {
            $basePath = RouteContext::fromRequest($request)->getBasePath();
            $target = $basePath . ($isLoggedIn ? '/logout' : '/');

            return (new Response())
                ->withHeader('Location', $target ?: '/')
                ->withStatus(302);
        }

        return $handler->handle($request);
    }
}
