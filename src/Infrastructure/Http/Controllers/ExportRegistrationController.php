<?php declare(strict_types=1);

namespace App\Infrastructure\Http\Controllers;

use App\Application\Usecases\ExportRegistration\ExportRegistration;
use App\Application\Usecases\ExportRegistration\InputBoundary;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

final class ExportRegistrationController
{
    private Request $request;
    private Response $response;
    private ExportRegistration $useCase;

    public function __construct(
        Request $request,
        Response $response,
        ExportRegistration $useCase
    ) {
        $this->request = $request;
        $this->response = $response;
        $this->useCase = $useCase;
    }

    public function handle(InputBoundary $input): Response
    {
        $output = $this->useCase->handle($input);

        $this->response
            ->getBody()
            ->write(json_encode([
                'fullFileName' => $output->getFullPath()
            ]));

        return $this->response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}
