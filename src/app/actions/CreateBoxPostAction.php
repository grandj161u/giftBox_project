<?php

namespace gift\appli\app\actions;

use gift\appli\app\utils\CsrfService;
use gift\appli\core\services\Box\ServiceBox;
use gift\appli\core\services\Catalogue\CatalogueNotFoundException;
use Slim\Exception\HttpNotFoundException;
use Slim\Routing\RouteContext;

class CreateBoxPostAction
{
    public function __invoke($request, $response, $args)
    {

        if (!isset($_SESSION['id'])) {
            // Utilisateur redirigé vers le formulaire de login s'il n'est pas authentifié
            $routeContext = RouteContext::fromRequest($request);
            $routeParser = $routeContext->getRouteParser();
            $loginUrl = $routeParser->urlFor('login'); // Adjust the route name as needed

            return $response->withStatus(302)->withHeader('Location', $loginUrl);
        }

        $boxService = new ServiceBox();
        $data = $request->getParsedBody();
        if (!CsrfService::check($data['csrf'])) {
            throw new HttpNotFoundException($request);
        }

        // On génère un token pour la box
        $token = base64_encode(random_bytes(32));

        $isKdo = $data['isKdo'] == 'true' ? 1 : 0;

        if ($data['boxPredefinie'] == 0) {
            $data['boxPredefinie'] = null;
        }

        // Si la case "Est-ce une box cadeau ?" n'est pas cochée, on ignore le "Message cadeau"
        $messageKdo = $isKdo ? $data['msgKdo'] : null;
        $messageKdo = htmlspecialchars($messageKdo, ENT_QUOTES, 'UTF-8');
        $libelle = htmlspecialchars($data['libelle'], ENT_QUOTES, 'UTF-8');
        $description = htmlspecialchars($data['description'], ENT_QUOTES, 'UTF-8');

        $tabNewBox = [
            'token' => $token,
            'libelle' => $libelle,
            'description' => $description,
            'isKdo' => $isKdo,
            'message_kdo' => $messageKdo,
            'createur_id' => $_SESSION['id'],
            'boxPredefinie' => $data['boxPredefinie']
        ];

        try {
            $idBoxCourante = $boxService->createBox($tabNewBox);
        } catch (CatalogueNotFoundException $e) {
            throw new HttpNotFoundException($request, $e->getMessage());
        }

        $_SESSION['idBoxCourante'] = $idBoxCourante;

        $routeContext = RouteContext::fromRequest($request);
        $routeParser = $routeContext->getRouteParser();
        $url = $routeParser->urlFor('listeBox');

        return $response->withStatus(302)->withHeader('Location', $url);
    }
}