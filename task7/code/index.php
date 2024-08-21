<?php


$memori_start = memory_get_usage();

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

$memori_end = memory_get_usage();
Application::$loger->error("Потреблено ". ($memori_end - $memori_start)/1024/1024 ."Мбайт памяти для метода " . $app->getMethodName() ."и контроллера ". $app->getControllerName());