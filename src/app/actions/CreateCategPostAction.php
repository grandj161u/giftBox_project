<?php

namespace gift\appli\app\actions;

use gift\appli\app\utils\CsrfService;
use gift\appli\core\services\ServiceCatalogue;
use Slim\Exception\HttpNotFoundException;
use Slim\Views\Twig;

class CreateCategPostAction
{
    public function __invoke($request, $response, $args)
    {
        $catalogue = new ServiceCatalogue();
        $data = $request->getParsedBody();
        if (!CsrfService::check($data['csrf'])) {
            throw new HttpNotFoundException($request);
        }
        $tabNewCateg = ['libelle' => $data['libelle'], 'description' => $data['description']];
        $catalogue->createCategorie($tabNewCateg);

        $csrf_token = CsrfService::generate();
        $view = Twig::fromRequest($request);
        return $view->render(
            $response,
            'CreateCateg.html.twig',
            [
                'csrf' => $csrf_token,
                'message' => 'Catégorie créée'
            ]
        );
    }
}
