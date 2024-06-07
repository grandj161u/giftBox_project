<?php

namespace gift\appli\app\actions;

use gift\appli\core\services\ServiceCatalogue;
use Slim\Views\Twig;

class ListePrestaAction
{

    public function __invoke($request, $response, $args) {

        $catalogue = new ServiceCatalogue();
        $prestations = $catalogue->getPrestations();

        $view = Twig::fromRequest($request);
        return $view->render(
            $response,
            'ListePrestaVue.html.twig',
            [
                'prestations' => $prestations
            ]
        );
    }
}
