<?php

namespace Geekbrains\Application1\Domain\Controllers;

use Geekbrains\Application1\Application\Application;
use Geekbrains\Application1\Application\Render;
use Geekbrains\Application1\Application\Auth;
use Geekbrains\Application1\Domain\Models\User;

class UserController extends AbstractController {

    protected array $actionsPermissions = [
        'actionHash' => ['admin', 'some'],
        'actionSave' => ['admin']
    ];

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
                    'users' => $users,
                    'isAdmin' => User::isAdmin ($_SESSION["id_user"] ?? null)
                ]);
        }
    }

    public function actionIndexRefresh(){
        $limit = null;
        
        if(isset($_POST['maxId']) && ($_POST['maxId'] > 0)){
            $limit = $_POST['maxId'];
        }

        $users = User::getAllUsersFromStorage($limit);
        $usersData = [];
        $userA = $this->getUserRoles();
        // array_push($usersData, '{role:'.$userA[0].'}');
        // print_r($userA);
        // $render = new Render();
 
        // if(!$users){
        //     return $render->renderPartial(
        //         'user-empty.tpl', 
        //         [
        //             'title' => 'Список пользователей в хранилище',
        //             'message' => "Список пуст или не найден"
        //         ]);
        // }
        // else{
        //     return $render->renderPartial(
        //         'user-index.tpl', 
        //         [
        //             'title' => 'Список пользователей в хранилище',
        //             'users' => $users
        //         ]);
        // }
       

        if(count($users) > 0) {
            foreach($users as $user){
                $usersData[] = $user->getUserDataAsArray();
            }
        }
        return json_encode($usersData);
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

    public function actionEdit(): string {
        $render = new Render();
        
        return $render->renderPageWithForm(
                'user-form.tpl', 
                [
                    'title' => 'Форма создания пользователя'
                ]);
    }

    public function actionAuth(): string {
        $render = new Render();
        
        return $render->renderPageWithForm(
                'user-auth.tpl', 
                [
                    'title' => 'Форма логина',
                    'auth_success' => '1'
                ]);
    }

    public function actionHash(): string {
        return Auth::getPasswordHash($_GET['pass_string']);
    }

    public function actionLogin(): string {
        $result = false;

        if(isset($_POST['login']) && isset($_POST['password'])){
            $result = Application::$auth->proceedAuth($_POST['login'], $_POST['password']);
        }
        
        if(!$result){
            $render = new Render();

            return $render->renderPageWithForm(
                'user-auth.tpl', 
                [
                    'title' => 'Форма логина',
                    'auth_success' => false,
                    'auth_error' => 'Неверные логин или пароль'
                ]);
        }
        else{
            header('Location: /');
            return "";
        }
    }
    public function actionLogout(): void {
        session_destroy();
        unset($_SESSION['auth']);
        header("Location: /");
        die();
    }

    public function actionDeluser(): string {
        $render = new Render();
        return $render->renderPageWithForm(
                'user-form-del.tpl', 
                [
                    'title' => 'Форма создания пользователя',
                    'userid' => (int) $_GET["user-id"],

                ]);
        if(User::exists($_GET['user-id'])){
           
        }
        
    }
    public function actionDel(): void {
        if (isset($_POST['id']) && User::exists((int)$_POST['id'])) {
            User::deleteFromStorage((int)$_POST['id']);
            // Можно вернуть сообщение о статусе удаления
            header('Content-Type: application/json');
            echo json_encode(['status' => 'success']);
        } else {
            header('Content-Type: application/json');
            echo json_encode(['status' => 'error', 'message' => 'User not found']);
        }
        exit();
    }
    
}

