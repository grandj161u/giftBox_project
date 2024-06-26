<?php

declare(strict_types=1);

use gift\appli\app\actions\BoxCouranteAction;
use gift\appli\app\actions\BoxsPredefinies;
use gift\appli\app\actions\CreateBoxGetAction;
use gift\appli\app\actions\CreateBoxPostAction;
use gift\appli\app\actions\CreateCategGetAction;
use gift\appli\app\actions\CreateCategPostAction;
use gift\appli\app\actions\DetailCategAction;
use gift\appli\app\actions\HomeAction;
use gift\appli\app\actions\ListeCategAction;
use gift\appli\app\actions\DetailPrestationAction;
use gift\appli\app\actions\ListePrestaAction;
use gift\appli\app\actions\DetailBoxAction;
use gift\appli\app\actions\AddPresta2BoxAction;
use gift\appli\app\actions\LogoutAction;
use gift\appli\app\actions\MesBoxsAction;
use gift\appli\app\actions\PayerBoxAction;
use gift\appli\app\actions\RegisterPostAction;
use gift\appli\app\actions\RegisterGetAction;
use gift\appli\app\actions\AuthGetAction;
use gift\appli\app\actions\AuthPostAction;
use gift\appli\app\actions\SupprimerPrestaDeBox;
use gift\appli\app\actions\ValiderBoxAction;
use gift\appli\app\actions\UpdatePrestaQtInBoxAction;
use gift\appli\app\actions\PasDeBoxCouranteAction;
use \gift\appli\app\actions\AccesBoxAction;
use \gift\appli\app\actions\GenererUrlAccesAction;
use \gift\appli\app\actions\DownloadBoxPdfAction;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;
use Slim\Routing\RouteCollectorProxy;



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
        '/pasDeBoxCourante',
        PasDeBoxCouranteAction::class
    )->setName('pasDeBoxCourante');

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
        BoxsPredefinies::class
    )->setName('listeBox');


    $app->get(
        '/register',
        RegisterGetAction::class
    )->setName('register');

    $app->post(
        '/register',
        RegisterPostAction::class
    );

    $app->get(
        '/login',
        AuthGetAction::class
    )->setName('login');

    $app->post(
        '/login',
        AuthPostAction::class
    )->setName('login');

    $app->get(
        '/box/{id}',
        DetailBoxAction::class
    )->setName('detailBox');

    $app->get(
        '/boxCourante',
        BoxCouranteAction::class
    )->setName('boxCourante');

    $app->get(
        '/logout',
        LogoutAction::class
    )->setName('logout');

    $app->get(
        '/validerBox',
        ValiderBoxAction::class
    )->setName('validerBox');

    $app->get(
        '/payerBox',
        PayerBoxAction::class
    )->setName('payerBox');

    $app->get(
        '/deletePrestaFromBox',
        SupprimerPrestaDeBox::class
    )->setName('deletePrestaFromBox');

    $app->get(
        '/mesBoxs',
        MesBoxsAction::class
    )->setName('mesBoxs');


    $app->get(
        '/updatePrestaQtInBox',
        UpdatePrestaQtInBoxAction::class
    )->setName('updatePrestaQtInBox');

    $app->get('/generate-url', GenererUrlAccesAction::class
        )->setName('genererUrlAcces');

    $app->get('/access/{token:.*}', AccesBoxAction::class)->setName('accessBox');

        
    $app->get('/download-box-pdf/{token:.*}', DownloadBoxPdfAction::class)
    ->setName('downloadBoxPdf');




    return $app;
};
