<?php

namespace gift\appli\app\actions;

use Exception;
use gift\appli\core\services\Box\ServiceBox;
use gift\appli\core\services\Catalogue\CatalogueNotFoundException;
use Slim\Exception\HttpNotFoundException;
use Slim\Views\Twig;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AccesBoxAction
{
    public function __invoke(Request $request, Response $response, $args)
    {
        $token = $args['token'];
        $serviceBox = new ServiceBox();

        try {
            $box = $serviceBox->getBoxByToken($token);
            $prestations = $serviceBox->getPrestationsByIdBox($box->id);
            $isKdo = $box->kdo;
            $message = $box->message_kdo;

            $twig = Twig::fromRequest($request);

            // Sélection du template en fonction du mode (normal ou cadeau)
            $template = $isKdo ? 'AccesBoxKdo.html.twig' : 'AccesBox.html.twig';

            return $twig->render($response, $template, [
                'box' => $box,
                'prestations' => $prestations,
                'isKdo' => $isKdo,
                'message' => $message,
            ]);
        } catch (\Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
