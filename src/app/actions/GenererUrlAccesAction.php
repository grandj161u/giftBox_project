<?php

namespace gift\appli\app\actions;

use Exception;
use gift\appli\core\services\Box\ServiceBox;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Log\LoggerInterface;
use Slim\Views\Twig;

class GenererUrlAccesAction
{
    public function __invoke(Request $request, Response $response, $args)
    {
        $view = $request->getAttribute('view');

        $boxId = $request->getQueryParams()['id'] ?? null;
        $serviceBox = new ServiceBox();

        try {
            $accessUrl = $serviceBox->generateAccesURL($boxId);

            // Rendre le template Twig avec les données nécessaires
            return $view->render($response, 'AccesUrlBox.html.twig', [
                'accessUrl' => $accessUrl,
            ]);
        } catch (\Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
