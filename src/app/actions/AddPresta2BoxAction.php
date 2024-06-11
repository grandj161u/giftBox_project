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

        if (is_null($idPresta)) {
            throw new HttpNotFoundException($request, "Identifiant de prestation manquant");
        }

        $idBox = $_SESSION['idBoxCourante'] ?? null;

        var_dump($_SESSION);

        if (is_null($idBox)) {
            throw new HttpNotFoundException($request, "Identifiant de box manquant");
        }

        $boxService->addPrestationToBox($idBox, $idPresta);

        $routeContext = \Slim\Routing\RouteContext::fromRequest($request);
        $routeParser = $routeContext->getRouteParser();
        $url = $routeParser->urlFor('detailPrestation', [], ['id' => $idPresta]);

        return $response->withStatus(302)->withHeader('Location', $url);
    }
}
