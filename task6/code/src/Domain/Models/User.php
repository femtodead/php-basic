<?php

namespace Geekbrains\Application1\Domain\Models;

use Geekbrains\Application1\Application\Application;
use Geekbrains\Application1\Infrastructure\Storage;

class User {

    private ?int $idUser;

    private ?string $userName;

    private ?string $userLastName;
    private ?int $userBirthday;



    public function __construct(string $name = null, string $lastName = null, int $birthday = null, int $id_user = null){
        $this->userName = $name;
        $this->userLastName = $lastName;
        $this->userBirthday = $birthday;
        $this->idUser = $id_user;
    }

    public function setUserId(int $id_user): void {
        $this->idUser = $id_user;
    }

    public function getUserId(): ?int {
        return $this->idUser;
    }

    public function setName(string $userName) : void {
        $this->userName = $userName;
    }

    public function setLastName(string $userLastName) : void {
        $this->userLastName = $userLastName;
    }

    public function getUserName(): string {
        return $this->userName;
    }

    public function getUserLastName(): string {
        return $this->userLastName;
    }

    public function getUserBirthday(): int {
        return $this->userBirthday;
    }

    public function setBirthdayFromString(string $birthdayString) : void {
        $this->userBirthday = strtotime($birthdayString);
    }

    public static function getAllUsersFromStorage(): array {
        $sql = "SELECT * FROM users";

        $handler = Application::$storage->get()->prepare($sql);
        $handler->execute();
        $result = $handler->fetchAll();

        $users = [];

        foreach($result as $item){
            $user = new User($item['user_name'], $item['user_lastname'], $item['user_birthday_timestamp']);
            $users[] = $user;
        }
        
        return $users;
    }

    public static function validateRequestData(): bool{
        if(
            isset($_GET['name']) && !empty($_GET['name']) &&
            isset($_GET['lastname']) && !empty($_GET['lastname']) &&
            isset($_GET['birthday']) && !empty($_GET['birthday'])
        ){
            return true;
        }
        else{
            return false;
        }
    }

    public function setParamsFromRequestData(): void {
        $this->userName = $_GET['name'];
        $this->userLastName = $_GET['lastname'];
        $this->setBirthdayFromString($_GET['birthday']); 
    }

    public function saveToStorage(){
        $sql = "INSERT INTO users(user_name, user_lastname, user_birthday_timestamp) VALUES (:user_name, :user_lastname, :user_birthday)";

        $handler = Application::$storage->get()->prepare($sql);
        $handler->execute([
            'user_name' => $this->userName,
            'user_lastname' => $this->userLastName,
            'user_birthday' => $this->userBirthday
        ]);
    }

    public static function exists(int $id): bool{ // Метод для проверки существования пользователя по идентификатору
        $sql = "SELECT count(id_user) as user_count FROM users WHERE id_user = :id_user"; // SQL-запрос для подсчета пользователей

        $handler = Application::$storage->get()->prepare($sql); // Подготовка SQL-запроса
        $handler->execute([ // Выполнение запроса с параметрами
            'id_user' => $id
        ]);
        //фактически для нашего sql это будет выглядить примерно как-то так
        // PREPARE stmt FROM "SELECT count(id_user) as user_count FROM users WHERE id_user = :id_user";
        // SET @id_user = 42; вспоминием запрос в контролере(//user/update/?id=42&name=Петр)
        // EXECUTE stmt USING @id_user;

        $result = $handler->fetchAll(); // извлекаем все строки результата запроса описаного выше в виде массива

        if(count($result) > 0 && $result[0]['user_count'] > 0){ // соответсвенное если пользователь существует то в поле user_count будет значение выше нуля(вообще id у нас первичный ключ поэтому там может быть только два значения 1 или 0)
            return true; // Пользователь существует
        }
        else{
            return false; // Пользователь не существует
        }
    }

    public function updateUser(array $userDataArray, int $id): void{ // Метод для обновления данных пользователя
        $sql = "UPDATE users SET "; // Начало SQL-запроса для обновления

        $counter = 0; // Счетчик для отслеживания последнего элемента
        foreach($userDataArray as $key => $value) { // Перебор массива данных пользователя
            $sql .= $key ." = :".$key; // довормировываем запрос в sql UPDATE users SET user_name = :user_name, user_lastname = :user_lastname (этот пример будет в случае запроса в браузер в виде user/update/?id=1&name=Иван&lastname=Иванов, userDataArray мы формируем в методе actionUpdate в контроллере(вид у него будет в данном случае  ['user_name' => Иван, user_lastname => Иванов]))

            if($counter != count($userDataArray)-1) { // Если это не последний элемент
                $sql .= ","; // Добавление запятой
            }

            $counter++; // Увеличение счетчика
        }

        $sql .= " WHERE id_user = :id_user"; // (изменил запрос чтобы меняло не всех пользователь а одного по id)

        $handler = Application::$storage->get()->prepare($sql); // Подготовка SQL-запроса
        $userDataArray[':id_user'] = $id; // Добавляем id в массив параметров
        $handler->execute($userDataArray); // Выполнение запроса с параметрами

    }

    public static function deleteFromStorage(int $user_id) : void { // Метод для удаления пользователя из хранилища
        $sql = "DELETE FROM users WHERE id_user = :id_user"; // SQL-запрос для удаления пользователя, тут все по анологии с update просто проще нам не нужно доформировывать запрос а просто 
        // подстваить удаляемый id, проверка на существование в контроллере

        $handler = Application::$storage->get()->prepare($sql); // Подготовка SQL-запроса
        $handler->execute(['id_user' => $user_id]); // Выполнение запроса с параметрами
    }
}