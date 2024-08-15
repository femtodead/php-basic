<?php

namespace Geekbrains\Application1\Domain\Controllers;

use Geekbrains\Application1\Application\Render;
use Geekbrains\Application1\Domain\Models\User;

class UserController {

    public function actionIndex(): string {
        $users = User::getAllUsersFromStorage();
        
        $render = new Render();

        if(!$users){
            return $render->renderPage(
                'user-empty.tpl', 
                [
                    'title' => 'Список пользователей в хранилище',
                    'message' => "Список пуст или не найден"
                ]);
        }
        else{
            return $render->renderPage(
                'user-index.tpl', 
                [
                    'title' => 'Список пользователей в хранилище',
                    'users' => $users
                ]);
        }
    }

    public function actionSave(): string {
        if(User::validateRequestData()) {
            $user = new User();
            $user->setParamsFromRequestData();
            $user->saveToStorage();

            $render = new Render();

            return $render->renderPage(
                'user-created.tpl', 
                [
                    'title' => 'Пользователь создан',
                    'message' => "Создан пользователь " . $user->getUserName() . " " . $user->getUserLastName()
                ]);
        }
        else {
            throw new \Exception("Переданные данные некорректны");
        }
    }

    public function actionUpdate(): string { // Метод для обновления данных пользователя
        if(User::exists($_GET['id'] )) { // Проверка существования пользователя, описана в статичной функции в классе User, как аргумант передаем значение выдернутое из запроса например (//user/update/?id=42&name=Петр в аргумент упадет 42), функция проверит существует в бд пользователь с данным id и вернет либо true либо folse
            $user = new User(); // Создание нового экземпляра класса User
            $user->setUserId($_GET['id']); // Установка идентификатора пользователя
            
            $arrayData = []; // Массив для хранения данных обновления

            if(isset($_GET['name'])) // Если передано имя
                $arrayData['user_name'] = $_GET['name']; // Установка имени

            if(isset($_GET['lastname'])) { // Если передана фамилия
                $arrayData['user_lastname'] = $_GET['lastname']; // Установка фамилии
            }
            
            $user->updateUser($arrayData, $_GET['id']); // Обновление данных пользователя, (изменил чтобы меняло не всех пользователь а одного по id)
        }
        else { // Если пользователь не существует
            throw new \Exception("Пользователь не существует"); // Генерация исключения
        }

        $render = new Render(); // Создание объекта Render
        return $render->renderPage( // Отображение страницы с сообщением об обновлении пользователя
            'user-created.tpl', 
            [
                'title' => 'Пользователь обновлен',
                'message' => "Обновлен пользователь " . $user->getUserId()
            ]);
    }

    public function actionDelete(): string { // Метод для удаления пользователя
        if(User::exists($_GET['id'])) { // Проверка существования пользователя
            User::deleteFromStorage($_GET['id']); // Удаление пользователя из bd

            $render = new Render(); // Создание объекта Render
            
            return $render->renderPage( // Отображение страницы с сообщением об удалении пользователя
                'user-removed.tpl', []
            );
        }
        else { // Если пользователь не существует
            throw new \Exception("Пользователь не существует"); // Генерация исключения
        }
    }
}