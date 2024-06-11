<?php

declare(strict_types=1);

use gift\appli\api\utils\ConnectionBD;
use Slim\Factory\AppFactory;

/* application boostrap */

$app = AppFactory::create();

$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, false, false);

$app = (require_once __DIR__ . '/../conf/routes.php')($app);

ConnectionBD::init(__DIR__ . '/../conf/gift.db.conf.ini.dist');

return $app;
