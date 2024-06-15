<?php

namespace gift\appli\app\actions;

use gift\appli\app\utils\CsrfService;
use gift\appli\core\services\Box\ServiceBox;
use gift\appli\core\services\Catalogue\CatalogueNotFoundException;
use Slim\Exception\HttpNotFoundException;

class CreateBoxPostAction
{
    public function __invoke($request, $response, $args)
    {
        $boxService = new ServiceBox();
        $data = $request->getParsedBody();
        if (!CsrfService::check($data['csrf'])) {
            throw new HttpNotFoundException($request);
        }

        // On génère un token pour la box
        $token = base64_encode(random_bytes(32));

        $isKdo = $data['isKdo'] == 'true' ? 1 : 0;

        // Si la case "Est-ce une box cadeau ?" n'est pas cochée, on ignore le "Message cadeau"
        $messageKdo = $isKdo ? $data['msgKdo'] : null;

        $tabNewBox = ['token' => $token, 'libelle' => $data['libelle'], 'description' => $data['description'], 'isKdo' => $isKdo, 'message_kdo' => $messageKdo];
        try {
            $idBoxCourante = $boxService->createBox($tabNewBox);
        } catch (CatalogueNotFoundException $e) {
            throw new HttpNotFoundException($request, $e->getMessage());
        }

        $_SESSION['idBoxCourante'] = $idBoxCourante;

        $routeContext = \Slim\Routing\RouteContext::fromRequest($request);
        $routeParser = $routeContext->getRouteParser();
        $url = $routeParser->urlFor('listeBox');

        return $response->withStatus(302)->withHeader('Location', $url);
    }
}
