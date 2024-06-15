<?php

declare(strict_types=1);

use gift\appli\utils\ConnectionBD;
use Slim\Factory\AppFactory;

/* application boostrap */

$app = AppFactory::create();

$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, false, false);

$app = (require_once __DIR__ . '/../conf/routes.php')($app);

ConnectionBD::init(__DIR__ . '/../conf/gift.db.conf.ini.dist');

$twig = \Slim\Views\Twig::create(
    __DIR__ . '/../app/views',
    [
        'cache' => false,
        'debug' => true,
        'auto_reload' => true
    ]
);

$environment = $twig->getEnvironment();
$environment->addGlobal('session', $_SESSION);

//On ajoute les extensions de debug
$twig->addExtension(new \Twig\Extension\DebugExtension());

$app->add(\Slim\Views\TwigMiddleware::create($app, $twig));

return $app;
