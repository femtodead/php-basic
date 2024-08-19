<?php


require_once('./vendor/autoload.php');

use Geekbrains\Application1\Application\Application;

try{
    $app = new Application();

    $result = $app->run();

    echo $result;
}
catch(Exception $e){
    echo $e->getMessage();
}

