<?php

namespace gift\appli\app\actions;

use gift\appli\core\services\Box\ServiceBox;
use Slim\Views\Twig;

class ListeBoxAction
{

    public function __invoke($request, $response, $args)
    {
        $serviceBox = new ServiceBox();

        $box = $serviceBox->getAllBox();

        $view = Twig::fromRequest($request);
        return $view->render(
            $response,
            'ListeBoxVue.html.twig',
            [
                'box' => $box,
            ]
        );
    }
}
