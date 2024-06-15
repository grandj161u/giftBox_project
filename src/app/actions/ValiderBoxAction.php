<?php

namespace gift\appli\app\actions;

use gift\appli\core\services\Box\ServiceBox;
use Slim\Exception\HttpNotFoundException;

class ValiderBoxAction
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

        $serviceBox->validerBox($idBox, $idConnecte);
    }
}