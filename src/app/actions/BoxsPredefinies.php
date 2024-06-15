<?php

namespace gift\appli\app\actions;

use gift\appli\core\services\Box\ServiceBox;
use gift\appli\core\services\Catalogue\CatalogueNotFoundException;
use Slim\Exception\HttpNotFoundException;
use Slim\Views\Twig;

class BoxsPredefinies
{

    public function __invoke($request, $response, $args)
    {
        $serviceBox = new ServiceBox();

        try {
            $box = $serviceBox->getAllBoxPredefinies();
        } catch (CatalogueNotFoundException $e) {
            throw new HttpNotFoundException($request, $e->getMessage());
        }

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