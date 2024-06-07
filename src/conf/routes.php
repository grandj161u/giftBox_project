<?php

declare(strict_types=1);

use gift\appli\app\actions\CreateBoxGetAction;
use gift\appli\app\actions\CreateBoxPostAction;
use gift\appli\app\actions\CreateCategGetAction;
use gift\appli\app\actions\CreateCategPostAction;
use gift\appli\app\actions\DetailCategAction;
use gift\appli\app\actions\HomeAction;
use gift\appli\app\actions\ListeCategAction;
use gift\appli\app\actions\DetailPrestationAction;
use gift\appli\app\actions\ListePrestaAction;
use gift\appli\app\actions\ListeBoxAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

return function (\Slim\App $app): \Slim\App {

    /* home */
    $app->get('/', HomeAction::class)
        ->setName('home');

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

    $app->get(
        '/box/createBox',
        CreateBoxGetAction::class
    );

    $app->post(
        '/box/createBox',
        CreateBoxPostAction::class
    );

    $app->get(
        '/box',
        ListeBoxAction::class
    );

    // $app->get(
    //     '/box/{id}',
    //     DetailBoxAction::class
    // );

    return $app;
};
