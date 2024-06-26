<?php

namespace gift\appli\app\actions;

use gift\appli\core\services\Box\ServiceBox;
use Slim\Exception\HttpNotFoundException;
use Slim\Views\Twig;

class DetailBoxAction
{
    public function __invoke($request, $response, $args)
    {
        $serviceBox = new ServiceBox();

        try {
            $box = $serviceBox->getBoxById($args['id']);
            $prestations = $serviceBox->getPrestationsByIdBox($box['id']);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            throw new HttpNotFoundException($request, "La catégorie {$args['id']} n'existe pas", $e);
        }

        $view = Twig::fromRequest($request);
        return $view->render(
            $response,
            'BoxVue.html.twig',
            [
                'box' => $box,
                'prestations' => $prestations
            ]
        );
    }
}
