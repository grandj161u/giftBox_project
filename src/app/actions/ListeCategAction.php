<?php

namespace gift\appli\app\actions;

use gift\appli\utils\ConnectionBD;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\Twig;
use gift\appli\core\services\ServiceCatalogue;

class ListeCategAction
{

    public function __invoke($request, $response, $args)
    {
        $catalogue = new ServiceCatalogue();

        $categories = $catalogue->getCategories();

        $view = Twig::fromRequest($request);
        return $view->render(
            $response,
            'ListeCategorieVue.html.twig',
            [
                'categories' => $categories,
            ]
        );
    }
}
