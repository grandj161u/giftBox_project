<?php

namespace gift\appli\api\app\actions;

use gift\appli\api\core\services\BoxesService;

class BoxesAction
{
    public function __invoke($request, $response, $args)
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