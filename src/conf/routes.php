<?php

declare(strict_types=1);

use gift\appli\app\actions\BoxCouranteAction;
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
use gift\appli\app\actions\DetailBoxAction;
use gift\appli\app\actions\AddPresta2BoxAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

return function (\Slim\App $app): \Slim\App {

    /* home */
    $app->get('/', HomeAction::class)
        ->setName('home');

    $app->get(
        '/categories',
        ListeCategAction::class
    )->setName('listeCategories');

    $app->get(
        '/categorie/{id}',
        DetailCategAction::class
    )->setName('detailCategorie');

    $app->get(
        '/prestations',
        ListePrestaAction::class
    )->setName('listePrestations');

    $app->get(
        '/prestation',
        DetailPrestationAction::class
    )->setName('detailPrestation');

    $app->get(
        '/prestation/addPresta2Box',
        AddPresta2BoxAction::class
    )->setName('addPresta2Box');

    $app->get(
        '/categories/createCateg',
        CreateCategGetAction::class
    )->setName('createCategGet');

    $app->post(
        '/categories/createCateg',
        CreateCategPostAction::class
    )->setName('createCategPost');

    $app->get(
        '/box/createBox',
        CreateBoxGetAction::class
    )->setName('createBoxGet');

    $app->post(
        '/box/createBox',
        CreateBoxPostAction::class
    )->setName('createBoxPost');

    $app->get(
        '/box',
        ListeBoxAction::class
    )->setName('listeBox');

    $app->get(
        '/box/{id}',
        DetailBoxAction::class
    )->setName('detailBox');

    $app->get(
        '/boxCourante',
        BoxCouranteAction::class
    )->setName('boxCourante');

    return $app;
};
