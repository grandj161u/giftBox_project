<?php

namespace gift\appli\api\app\actions;

use gift\appli\api\core\services\PrestationService;

class PrestationsAction
{

    public function __invoke($request, $response, $args)
    {
        $prestationService = new PrestationService();
        $prestations = $prestationService->getAll();

        $data = [ 'type' => 'resource',
            'count' => count($prestations),
            'prestations' => $prestations ];

        $response->getBody()->write(json_encode($data));

        return
            $response->withHeader('Content-Type','application/json')
                ->withStatus(200);
    }
}