<?php

use app\base\App;

$config = include $_SERVER['DOCUMENT_ROOT'] . "/../config/main.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/../vendor/autoload.php";

App::call()->run($config);



