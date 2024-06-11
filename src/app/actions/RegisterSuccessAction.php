<?php

namespace gift\appli\app\actions;

use Slim\Views\Twig;

class RegisterSuccessAction {
    public function __invoke($request, $response, $args)
    {
        $view = Twig::fromRequest($request);
        return $view->render($response, 'RegisterSuccessful.html.twig',[]);
    }
}