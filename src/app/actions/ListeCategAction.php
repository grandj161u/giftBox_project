<?php

namespace gift\appli\app\actions;

use Slim\Views\Twig;
use gift\appli\core\services\Catalogue\ServiceCatalogue;

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
