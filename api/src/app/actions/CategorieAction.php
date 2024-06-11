<?php

namespace gift\appli\api\app\actions;

use gift\appli\api\core\services\CategorieService;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class CategorieAction
{
    public function __invoke(Request $request, Response $response, $args)
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