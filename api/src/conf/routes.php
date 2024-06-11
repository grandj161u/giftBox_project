<?php

declare(strict_types=1);

use gift\appli\api\app\actions\CategorieAction;

return function (\Slim\App $app): \Slim\App {

    $app->get('/api/categories', CategorieAction::class);

    return $app;
};
