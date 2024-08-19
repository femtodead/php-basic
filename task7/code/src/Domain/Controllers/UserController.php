<?php

namespace Geekbrains\Application1\Domain\Controllers;

use Geekbrains\Application1\Application\Application;
use Geekbrains\Application1\Application\Render;
use Geekbrains\Application1\Application\Auth;
use Geekbrains\Application1\Domain\Models\User;

class UserController extends AbstractController {

    protected array $actionsPermissions = [
        'actionHash' => ['admin'],
        'actionSave' => ['admin'],
        'actionIndex' => ['admin'],
        'actionEdit' => ['admin'],
        'actionLogout' => ['admin'],
        'actionLogin' => ['admin']
    ];

    public function actionLogout(): string {
        session_unset();
        session_destroy();
        header('Location: /');
        exit();
    }

    public function actionIndex(): string {
        $users = User::getAllUsersFromStorage();
        $render = new Render();

        if (!$users) {
            return $render->renderPage(
                'user-empty.tpl', 
                [
                    'title' => 'Список пользователей в хранилище',
                    'message' => "Список пуст или не найден"
                ]
            );
        } else {
            return $render->renderPage(
                'user-index.tpl', 
                [
                    'title' => 'Список пользователей в хранилище',
                    'users' => $users
                ]
            );
        }
    }

    public function actionSave(): string {
        $app = new Application();
        $csrfToken = $_POST['csrf_token'] ?? null;  // Проверяем наличие токена
    
        if ($csrfToken && $app->validateCsrfToken($csrfToken)) {
            if (User::validateRequestData()) {
                $user = new User();
                $user->setParamsFromRequestData();
                $user->saveToStorage();
    
                $render = new Render();
                return $render->renderPage(
                    'user-created.tpl', 
                    [
                        'title' => 'Пользователь создан',
                        'message' => "Создан пользователь " . $user->getUserName() . " " . $user->getUserLastName()
                    ]
                );
            } else {
                throw new \Exception("Переданные данные некорректны");
            }
        } else {
            throw new \Exception("CSRF токен недействителен или отсутствует");
        }
    }

    public function actionEdit(): string {
        $app = new Application();
        $render = new Render();
        return $render->renderPageWithForm(
            'user-form.tpl', 
            [
                'title' => 'Форма создания пользователя',
                'csrf_token' => $app->generateCsrfToken()  // Генерация и передача CSRF токена в форму
            ]
        );
    }

    public function actionAuth(): string {
        $app = new Application();
        $render = new Render();
        return $render->renderPageWithForm(
            'user-auth.tpl', 
            [
                'title' => 'Форма логина',
                'csrf_token' => $app->generateCsrfToken()  // Генерация и передача CSRF токена в форму
            ]
        );
    }

    public function actionHash(): string {
        return Auth::getPasswordHash($_GET['pass_string']);
    }

    public function actionLogin(): string {
        $app = new Application();
        $csrfToken = $_POST['csrf_token'] ?? null;  // Проверяем наличие токена
    
        if ($csrfToken && $app->validateCsrfToken($csrfToken)) {
            $result = false;
            if (isset($_POST['login']) && isset($_POST['password'])) {
                $result = Application::$auth->proceedAuth($_POST['login'], $_POST['password']);
            }
    
            if (!$result) {
                $render = new Render();
                return $render->renderPageWithForm(
                    'user-auth.tpl', 
                    [
                        'title' => 'Форма логина',
                        'auth-success' => false,
                        'auth-error' => 'Неверные логин или пароль',
                        'csrf_token' => $app->generateCsrfToken()  // Генерация нового токена при ошибке
                    ]
                );
            } else {
                header('Location: /');
                return "";
            }
        } else {
            throw new \Exception("CSRF токен недействителен или отсутствует");
        }
    }

    public function actionUpdate(): string {
        $app = new Application();
        
        // Проверка наличия CSRF токена в POST данных
        if (!isset($_POST['csrf_token'])) {
            throw new \Exception("CSRF токен отсутствует");
        }
    
        // Валидация токена
        if ($app->validateCsrfToken($_POST['csrf_token'])) {
            if (isset($_POST['id']) && User::validateRequestData()) {
                $user = User::getUserById($_POST['id']);
                $user->setParamsFromRequestData();
                $user->saveToStorage();
    
                $render = new Render();
                return $render->renderPage(
                    'user-updated.tpl', 
                    [
                        'title' => 'Пользователь обновлен',
                        'message' => 'Данные пользователя обновлены: ' . $user->getUserName() . ' ' . $user->getUserLastName()
                    ]
                );
            } else {
                throw new \Exception("Некорректные данные для обновления");
            }
        } else {
            throw new \Exception("CSRF токен недействителен");
        }
    }

    public function actionRemove(): string {
        $app = new Application();
        if ($app->validateCsrfToken($_POST['csrf_token'])) {
            User::deleteUserById($_POST['id']);
            $render = new Render();
            return $render->renderPage(
                'user-deleted.tpl', 
                [
                    'title' => 'Пользователь удален',
                    'message' => 'Пользователь успешно удален'
                ]
            );
        } else {
            throw new \Exception("CSRF токен недействителен");
        }
    }
}