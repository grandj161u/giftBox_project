<?php

declare(strict_types=1);

use gift\appli\app\actions\CreateCategGetAction;
use gift\appli\app\actions\CreateCategPostAction;
use gift\appli\app\actions\DetailCategAction;
use gift\appli\app\actions\ListeCategAction;
use gift\appli\app\actions\DetailPrestationAction;
use gift\appli\app\actions\ListePrestaAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

return function (\Slim\App $app): \Slim\App {

    $app->get(
        '/categories',
        ListeCategAction::class
    );

    $app->get(
        '/categorie/{id}',
        DetailCategAction::class
    );

    $app->get(
        '/prestations',
        ListePrestaAction::class
    );

    $app->get(
        '/prestation',
        DetailPrestationAction::class
    );

    $app->get(
        '/categories/createCateg',
        CreateCategGetAction::class
    );

    $app->post(
        '/categories/createCateg',
        CreateCategPostAction::class
    );


    return $app;
};
