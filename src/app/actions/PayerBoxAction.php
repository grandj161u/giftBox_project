<?php

namespace gift\appli\app\actions;

use gift\appli\core\services\Box\ServiceBox;
use gift\appli\core\services\Catalogue\CatalogueNotFoundException;
use Slim\Exception\HttpNotFoundException;

class PayerBoxAction
{

    public function __invoke($request, $response, $args)
    {
        $idBox = $request->getQueryParams()['id'] ?? null;

        if (is_null($idBox)) {
            throw new HttpNotFoundException($request, "Identifiant de box manquant");
        }

        if (isset($_SESSION['id'])) {
            $idConnecte = $_SESSION['id'];
        } else {
            throw new HttpNotFoundException($request, "Utilisateur non connecté");
        }

        $serviceBox = new ServiceBox();

        try {
            $serviceBox->payerBox($idBox, $idConnecte);
        } catch (CatalogueNotFoundException $e) {
            throw new HttpNotFoundException($request, $e->getMessage());
        }

        $routeContext = \Slim\Routing\RouteContext::fromRequest($request);
        $routeParser = $routeContext->getRouteParser();
        $url = $routeParser->urlFor('listeBox');

        return $response->withStatus(302)->withHeader('Location', $url);

    }
}