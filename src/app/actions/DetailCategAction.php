<?php

namespace gift\appli\app\actions;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;
use gift\appli\core\services\ServiceCatalogue;
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

        $tabNewCateg = ['libelle' => 'Bonjour', 'description' => 'Je suis NLE'];

        $catalogue->createCategorie($tabNewCateg);


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
