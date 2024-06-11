<?php

namespace gift\appli\app\actions;

use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpNotFoundException;
use Slim\Views\Twig;
use gift\appli\core\services\Catalogue\ServiceCatalogue;

class DetailPrestationAction
{

    public function __invoke($request, $response, $args)
    {

        $id = $request->getQueryParams()['id'] ?? null;


        if (is_null($id)) {
            throw new HttpBadRequestException($request, "Identifiant de prestation manquant");
        }

        $catalogue = new ServiceCatalogue();

        try {
            $prestation = $catalogue->getPrestationById($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            throw new HttpNotFoundException($request, "La préstation {$id} n'existe pas", $e);
        }

        $view = Twig::fromRequest($request);
        return $view->render(
            $response,
            'PrestationVue.html.twig',
            [
                'prestation' => $prestation
            ]
        );
    }
}
