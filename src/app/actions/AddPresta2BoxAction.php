<?php

namespace gift\appli\app\actions;

use gift\appli\core\services\Box\ServiceBox;
use gift\appli\core\services\Catalogue\CatalogueNotFoundException;
use Slim\Exception\HttpNotFoundException;

class AddPresta2BoxAction
{
    public function __invoke($request, $response, $args)
    {
        $boxService = new ServiceBox();

        $idPresta = $request->getQueryParams()['id'] ?? null;

        $routeContext = \Slim\Routing\RouteContext::fromRequest($request);
        $routeParser = $routeContext->getRouteParser();

        if (is_null($idPresta)) {
            throw new HttpNotFoundException($request, "Identifiant de prestation manquant");
        }

        $url = $routeParser->urlFor('pasDeBoxCourante');

        $idBox = $_SESSION['idBoxCourante'] ?? null;

        if (is_null($idBox)) {
            return $response->withStatus(302)->withHeader('Location', $url);
        }

        if ($request->getQueryParams()['quantite'] == null) {
            $quantite = 1;
        } else {
            $quantite = intval($request->getQueryParams()['quantite']);
        }

        try {
            $boxService->addPrestationToBox($idBox, $idPresta, $quantite);
        } catch (CatalogueNotFoundException $e) {
            throw new HttpNotFoundException($request, $e->getMessage());
        }



        $url = $routeParser->urlFor('detailBox', ['id' => $idBox]);

        return $response->withStatus(302)->withHeader('Location', $url);
    }
}
