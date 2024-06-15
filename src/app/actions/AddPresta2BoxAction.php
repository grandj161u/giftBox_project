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
        var_dump($request->getQueryParams());

        $idPresta = $request->getQueryParams()['id'] ?? null;

        if (is_null($idPresta)) {
            throw new HttpNotFoundException($request, "Identifiant de prestation manquant");
        }

        $idBox = $_SESSION['idBoxCourante'] ?? null;

        if (is_null($idBox)) {
            throw new HttpNotFoundException($request, "Identifiant de box manquant");
        }

        $quantite = $request->getQueryParams()['quantite'] ?? 1;

        try {
            $boxService->addPrestationToBox($idBox, $idPresta, $quantite);
        } catch (CatalogueNotFoundException $e) {
            throw new HttpNotFoundException($request, $e->getMessage());
        }


        $routeContext = \Slim\Routing\RouteContext::fromRequest($request);
        $routeParser = $routeContext->getRouteParser();
        $url = $routeParser->urlFor('detailPrestation', [], ['id' => $idPresta]);

        return $response->withStatus(302)->withHeader('Location', $url);
    }
}
