<?php
require 'vendor/autoload.php';

$app = new \Slim\App;

define('CONST', true);
require 'app/libs/connect.php';
require 'app/routes/api.php';


$app->run();