<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Repositories\SurveyRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\PhpRenderer;

class OperatorController
{
    public function __construct(
        private readonly PhpRenderer $view,
        private readonly SurveyRepository $repo
    ) {
    }

    public function survey(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $counter = (string) ($request->getQueryParams()['id'] ?? $request->getQueryParams()['counter'] ?? '1');
        $operator = $this->repo->getUserById((int) $counter);

        return $this->view->render($response, 'operator.php', [
            'counter'       => $counter,
            'operator'      => $operator,
            'questions'     => $this->repo->getQuestionsByCounter($counter),
            'ratingOptions' => SurveyRepository::RATING_OPTIONS,
            'settings'      => $this->repo->getSettings(),
        ]);
    }

    public function submitSurvey(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $body = (array) ($request->getParsedBody() ?? []);
        $basePath = (string) ($this->view->getAttribute('basePath') ?? '');

        $counter = (string) ($request->getQueryParams()['id'] ?? $body['counter'] ?? '1');
        $this->repo->insertSurveyResponse((int) $counter, $counter, $body);

        $msg = 'Terima Kasih anda telah berpartisipasi untuk memberikan saran dan masukan yang terbaik bagi Kami.';
        $url = ($basePath . '/') ?: '/';
        $response->getBody()->write(sprintf(
            '<script>alert(%s);window.location.href=%s;</script>',
            json_encode($msg),
            json_encode($url)
        ));

        return $response->withHeader('Content-Type', 'text/html; charset=UTF-8');
    }
}
