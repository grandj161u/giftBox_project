<?php

namespace gift\appli\app\actions;

use gift\appli\core\services\Box\ServiceBox;
use gift\appli\core\services\Catalogue\CatalogueNotFoundException;
use Slim\Views\Twig;

class BoxCouranteAction
{
    public function __invoke($request, $response, $args)
    {
        $serviceBox = new ServiceBox();

        //On récupere en session la box courante
        if (isset($_SESSION['idBoxCourante'])) {
            try {
                $boxCourante = $serviceBox->getBoxById($_SESSION['idBoxCourante']);
                $prestations = $serviceBox->getPrestationsByIdBox($boxCourante['id']);
            } catch (CatalogueNotFoundException $e) {
                throw new \Slim\Exception\HttpNotFoundException($request, $e->getMessage());
            }
        } else {
            $boxCourante = null;
            $prestations = null;
        }

        $view = Twig::fromRequest($request);
        return $view->render(
            $response,
            'BoxVue.html.twig',
            [
                'box' => $boxCourante,
                'prestations' => $prestations
            ]
        );
    }
}