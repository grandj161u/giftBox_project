<?php

require_once __DIR__ . '/../src/vendor/autoload.php';
session_start();
/* application boostrap */
$app = require_once __DIR__ . '/../src/conf/bootstrap.php';
$app->run();
