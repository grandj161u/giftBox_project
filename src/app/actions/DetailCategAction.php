<?php

namespace gift\appli\app\actions;

use gift\appli\core\services\Catalogue\ServiceCatalogue;
use Slim\Exception\HttpNotFoundException;
use Slim\Views\Twig;

class DetailCategAction
{
    public function __invoke($request, $response, $args)
    {
        $catalogue = new ServiceCatalogue();

        try {
            $categ = $catalogue->getCategorieById($args['id']);
            $prestations = $catalogue->getPrestationsbyCategorie($categ['id']);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            throw new HttpNotFoundException($request, "La catégorie {$args['id']} n'existe pas", $e);
        }

        $view = Twig::fromRequest($request);
        return $view->render(
            $response,
            'CategorieVue.html.twig',
            [
                'categ' => $categ,
                'prestations' => $prestations
            ]
        );
    }
}
