<?php

namespace gift\appli\api\app\actions;

use gift\appli\api\core\services\categorie\CategorieService;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class PrestationsOfCategorie
{
    public function __invoke(Request $request, Response $response, $args)
    {
        $categorieService = new CategorieService();

        if (!isset($args['id'])) {
            $response->getBody()->write(json_encode(['error' => 'missing id']));

            return
                $response->withHeader('Content-Type','application/json')
                    ->withStatus(400);
        }

        $prestations = $categorieService->getPrestations($args['id']);

        $data = [ 'type' => 'resource',
            'count' => count($prestations),
            'prestations' => $prestations ];

        $response->getBody()->write(json_encode($data));

        return
            $response->withHeader('Content-Type','application/json')
                ->withStatus(200);
    }
}