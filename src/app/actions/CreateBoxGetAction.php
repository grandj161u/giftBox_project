<?php

namespace gift\appli\app\actions;

use gift\appli\app\utils\CsrfService;
use gift\appli\core\services\Box\ServiceBox;
use gift\appli\core\services\Catalogue\CatalogueNotFoundException;
use Slim\Exception\HttpNotFoundException;
use Slim\Views\Twig;

class CreateBoxGetAction
{
    public function __invoke($request, $response, $args)
    {
        // Générer un token CSRF
        $csrf_token = CsrfService::generate();

        //On récupère toutes les boxs prédéfinies
        $serviceBox = new ServiceBox();
        try {
            $box = $serviceBox->getAllBoxPredefinies();
        } catch (CatalogueNotFoundException $e) {
            throw new HttpNotFoundException($request, $e->getMessage());
        }

        $view = Twig::fromRequest($request);
        return $view->render(
            $response,
            'CreateBox.html.twig',
            [
                'csrf' => $csrf_token,
                'box' => $box,
            ]
        );
    }
}
