<?php

namespace gift\appli\app\actions;

use gift\appli\core\services\ServiceBox;
use gift\appli\utils\ConnectionBD;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\Twig;
use gift\appli\core\services\ServiceCatalogue;

class ListeBoxAction
{

    public function __invoke($request, $response, $args)
    {
        $serviceBox = new ServiceBox();

        $box = $serviceBox->getAllBox();

        $view = Twig::fromRequest($request);
        return $view->render(
            $response,
            'ListeBoxVue.html.twig',
            [
                'box' => $box,
            ]
        );
    }
}
