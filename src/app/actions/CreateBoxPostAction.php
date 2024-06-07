<?php

namespace gift\appli\app\actions;

use gift\appli\app\utils\CsrfService;
use gift\appli\core\services\ServiceBox;
use Slim\Exception\HttpNotFoundException;
use Slim\Views\Twig;

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

        $tabNewBox = ['token' => $token, 'libelle' => $data['libelle'], 'description' => $data['description'], 'isKdo' => $isKdo, 'message_kdo' => $data['msgKdo']];
        $boxService->createBox($tabNewBox);
        return $response->withStatus(302)->withHeader('Location', '/box');
    }
}
