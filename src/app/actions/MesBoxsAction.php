<?php

namespace gift\appli\app\actions;

use gift\appli\core\services\Box\ServiceBox;
use Slim\Views\Twig;

class MesBoxsAction
{
   
    public function __invoke($request, $response, $args)
    {
        $serviceBox = new ServiceBox();
        $twig = Twig::fromRequest($request);
        $sortOption = $request->getQueryParams()['sortOption'] ?? 'none';

        try {
            switch ($sortOption) {
                case 'valide':
                    $tabBox = $serviceBox->getBoxValidePourUser($_SESSION['id']);
                    break;

                case 'paye':
                    $tabBox = $serviceBox->getBoxPayeePourUser($_SESSION['id']);
                    break;

                default:
                    $tabBox = $serviceBox->getBoxDeUser($_SESSION['id']);
                break;
            }
        } catch (\Exception $e) {
            $response->getBody()->write($e->getMessage());
            return $response->withStatus(500);        
        }

        return $twig->render(
            $response,
            'ListeBoxVue.html.twig',
            [
                'box' => $tabBox,
            ]
        );
    }
}