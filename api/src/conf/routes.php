<?php

declare(strict_types=1);

use gift\appli\api\app\actions\BoxesAction;
use gift\appli\api\app\actions\CategorieAction;

return function (\Slim\App $app): \Slim\App {

    $app->get('/api/categories', CategorieAction::class)
        ->setName('categories');

    $app->get('/api/boxes/{ID}', BoxesAction::class)
        ->setName('box');


    return $app;
};
