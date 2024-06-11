<?php

namespace gift\appli\api\app\actions;

use gift\appli\api\core\services\CategorieService;

class CategorieAction
{
    public function __invoke($request, $response, $args)
    {
        $categorieService = new CategorieService();

        $categories = $categorieService->getAll();

        $data = [ 'type' => 'resource',
            'count' => count($categories),
            'categorie' => $categories ];

        $response->getBody()->write(json_encode($data));

        return
            $response->withHeader('Content-Type','application/json')
                ->withStatus(200);
    }
}