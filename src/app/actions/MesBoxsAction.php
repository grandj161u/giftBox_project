<?php

namespace gift\appli\app\actions;

use gift\appli\core\services\Box\ServiceBox;
use Slim\Views\Twig;

class MesBoxsAction
{

    public function __invoke($request, $response, $args)
    {
        $serviceBox = new ServiceBox();

        $tabBox = $serviceBox->getBoxDeUser($_SESSION['id']);

        $twig = Twig::fromRequest($request);
        return $twig->render(
            $response,
            'ListeBoxVue.html.twig',
            [
                'box' => $tabBox,
            ]
        );
    }
}