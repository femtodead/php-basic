<?php

namespace Geekbrains\Application1\Controllers;

use Geekbrains\Application1\Render;
use Geekbrains\Application1\Models\User;

class UserController {

    public function actionIndex() {
        $users = User::getAllUsersFromStorage();
        
        $render = new Render();

        if(!$users){
            return $render->renderPage(
                'user-empty.twig',
                [
                    'title' => 'Список пользователей в хранилище',
                    'message' => "Список пуст или не найден"
                ]);
        }
        else{
            return $render->renderPage(
                'user-index.twig',
                [
                    'title' => 'Список пользователей в хранилище',
                    'users' => $users
                ]);
        }
    }
    public function actionSave() {
        $name = $_GET['name'];
        $date = $_GET['birthday'];
        $data =  "\r\n". $name . ", " . $date ;
        $fileHandler = fopen("./storage/birthdays.txt", 'a');
        if(fwrite($fileHandler, $data)){

            return "Запись $data добавлена в файл";

        }

        else {

            return "Произошла ошибка записи. Данные не сохранены";

        }

        fclose("./storage/birthdays.txt");

    }
}