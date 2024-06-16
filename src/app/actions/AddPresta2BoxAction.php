<?php

namespace gift\appli\app\actions;

use gift\appli\core\services\Box\ServiceBox;
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

        if (!isset($_SESSION['idBoxCourante'])) {
            return $response->withStatus(302)->withHeader('Location', $url);
        }

        $idBox = $_SESSION['idBoxCourante'] ?? null;

        if (is_null($idBox)) {
            throw new HttpNotFoundException($request, "Identifiant de box manquant");
        }

        $boxService->addPrestationToBox($idBox, $idPresta);


        $url = $routeParser->urlFor('detailBox', ['id' => $idBox]);

        return $response->withStatus(302)->withHeader('Location', $url);
    }
}
