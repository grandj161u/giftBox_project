<?php

namespace gift\appli\app\actions;

use gift\appli\app\utils\CsrfService;
use gift\appli\core\services\ServiceCatalogue;
use Slim\Exception\HttpNotFoundException;
use Slim\Views\Twig;

class CreateCategGetAction
{
    public function __invoke($request, $response, $args)
    {
        $csrf_token = CsrfService::generate();
        $view = Twig::fromRequest($request);
        return $view->render(
            $response,
            'CreateCateg.html.twig',
            [
                'csrf' => $csrf_token
            ]
        );
    }
}
