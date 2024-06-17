<?php

namespace gift\appli\app\actions;

use gift\appli\app\utils\CsrfService;
use gift\appli\core\services\Catalogue\ServiceCatalogue;
use Slim\Exception\HttpNotFoundException;

class CreateCategPostAction
{
    public function __invoke($request, $response, $args)
    {
        $catalogue = new ServiceCatalogue();
        $data = $request->getParsedBody();
        if (!CsrfService::check($data['csrf'])) {
            throw new HttpNotFoundException($request);
        }

        $libelle = htmlspecialchars($data['libelle'], ENT_QUOTES, 'UTF-8');
        $description = htmlspecialchars($data['description'], ENT_QUOTES, 'UTF-8');

        $tabNewCateg = ['libelle' => $libelle, 'description' => $description];
        $catalogue->createCategorie($tabNewCateg);

        $routeContext = \Slim\Routing\RouteContext::fromRequest($request);
        $routeParser = $routeContext->getRouteParser();
        $url = $routeParser->urlFor('listeCategories');

        return $response->withStatus(302)->withHeader('Location', $url);
    }
}
