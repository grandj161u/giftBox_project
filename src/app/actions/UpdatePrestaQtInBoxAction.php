<?php

namespace gift\appli\app\actions;

use gift\appli\core\services\Box\ServiceBox;
use gift\appli\core\services\Catalogue\CatalogueNotFoundException;
use Slim\Exception\HttpNotFoundException;

class UpdatePrestaQtInBoxAction
{

    public function __invoke($request, $response)
    {
        $idPresta = $request->getQueryParams()['id'] ?? null;

        if (is_null($idPresta)) {
            throw new HttpNotFoundException($request, "Identifiant de prestation manquant");
        }

        $idBox = $_SESSION['idBoxCourante'] ?? null;

        if (is_null($idBox)) {
            throw new HttpNotFoundException($request, "Identifiant de box manquant");
        }

        $quantite = $request->getQueryParams()['quantite'] ?? 10;

        $serviceBox = new ServiceBox();

        try {
            $serviceBox->updateQtPrestaInBox($idBox, $idPresta, $quantite);
        } catch (CatalogueNotFoundException $e) {
            throw new HttpNotFoundException($request, $e->getMessage());
        }

        $routeContext = \Slim\Routing\RouteContext::fromRequest($request);
        $routeParser = $routeContext->getRouteParser();
        $url = $routeParser->urlFor('detailBox', ['id' => $idBox]);

        return $response->withStatus(302)->withHeader('Location', $url);
    }
}