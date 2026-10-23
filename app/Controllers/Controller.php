<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Repositories\SurveyRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\PhpRenderer;

abstract class Controller
{
    public function __construct(
        protected readonly PhpRenderer $view,
        protected readonly SurveyRepository $repo,
        protected readonly string $basePath = ''
    ) {
    }

    protected function render(
        ResponseInterface $response,
        string $template,
        array $data = []
    ): ResponseInterface {
        $data['basePath'] = $this->basePath;
        return $this->view->render($response, $template, $data);
    }

    protected function redirect(ResponseInterface $response, string $path): ResponseInterface
    {
        $location = $this->basePath . $path;
        return $response
            ->withHeader('Location', $location !== '' ? $location : '/')
            ->withStatus(302);
    }

    protected function alertAndRedirect(
        ResponseInterface $response,
        string $message,
        string $path
    ): ResponseInterface {
        $target = $this->basePath . $path;
        if ($target === '') {
            $target = '/';
        }

        $escapedMsg = json_encode($message, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
        $escapedUrl = json_encode($target, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);

        $response->getBody()->write(
            "<script type=\"text/javascript\">alert({$escapedMsg});window.location.href={$escapedUrl};</script>"
        );

        return $response->withHeader('Content-Type', 'text/html; charset=UTF-8');
    }
}
