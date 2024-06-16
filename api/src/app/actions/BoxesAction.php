<?php

namespace gift\appli\api\app\actions;

use gift\appli\api\core\services\boxes\BoxesService;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class BoxesAction
{
    public function __invoke(Request $request, Response $response, $args)
    {
        $boxesService = new BoxesService();

        $box = $boxesService->get($args['ID']);

        $data = [ 'type' => 'resource',
            'box' => $box ];

        $response->getBody()->write(json_encode($data));

        return
            $response->withHeader('Content-Type','application/json')
                ->withStatus(200);
    }
}