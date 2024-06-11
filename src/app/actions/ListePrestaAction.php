<?php

namespace gift\appli\app\actions;

use gift\appli\core\services\Catalogue\ServiceCatalogue;
use Slim\Views\Twig;

class ListePrestaAction
{

    public function __invoke($request, $response, $args) {
        $queryParams = $request->getQueryParams();
        $sortOptions = (isset($queryParams['sortOption']) && ($queryParams['sortOption'] == 'asc' || $queryParams['sortOption'] == 'desc')) ?? false;

        $catalogue = new ServiceCatalogue();
        if ($sortOptions) {
            $prestations = $catalogue->getPrestationsSortByTarif($queryParams['sortOption']);
        } else {
            $prestations = $catalogue->getPrestations();
        }

        $view = Twig::fromRequest($request);
        return $view->render(
            $response,
            'ListePrestaVue.html.twig',
            [
                'prestations' => $prestations,
            ]
        );
    }
}
