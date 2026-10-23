<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Repositories\SurveyRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class OperatorController extends Controller
{
    public function survey(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $counter = '1';
        $questions = $this->repo->getQuestionsByCounter($counter);

        return $this->render($response, 'operator/survey.php', [
            'counter'       => $counter,
            'questions'     => $questions,
            'ratingOptions' => SurveyRepository::RATING_OPTIONS,
        ]);
    }

    public function submitSurvey(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $query = $request->getQueryParams();
        $body = (array) ($request->getParsedBody() ?? []);

        $counter = (string) ($query['id'] ?? $body['counter'] ?? '1');
        $userId = (int) ($_SESSION['id'] ?? 0);

        if (($body['q1'] ?? '') === 'logout') {
            return $this->redirect($response, '/logout');
        }

        $this->repo->insertSurveyResponse($userId, $counter, $body);

        return $this->alertAndRedirect(
            $response,
            'Terima Kasih anda telah berpartisipasi untuk memberikan saran dan masukan yang terbaik bagi Kami.',
            '/operator/survey'
        );
    }
}
