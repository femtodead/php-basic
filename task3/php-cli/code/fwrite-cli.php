<?php

$address = '/code/birthdays.txt';

$name = readline("Введите имя: ");
$date = readline("Введите дату рождения в формате ДД-ММ-ГГГГ: ");

if(validate($date)){
    $data = $name . ", " . $date . "\r\n";
    
    $fileHandler = fopen($address, 'a');
    
    if(fwrite($fileHandler, $data)){
        echo "Запись $data добавлена в файл $address";
    }
    else {
        echo "Произошла ошибка записи. Данные не сохранены";
    }
    
    fclose($fileHandler);
}
else{
    echo "Введена некорректная информация";
}
// 1. Обработка ошибок. Посмотрите на реализацию функции в файле fwrite-cli.php в исходниках. Может ли пользователь ввести некорректную информацию (например, дату в виде 12-50-1548)? Какие еще некорректные данные могут быть введены? Исправьте это, добавив соответствующие обработки ошибок.


function validate(string $date): bool { // перелопатил валидатор если запярится можно былобы еще продумать ввод дат до нашей эры, но концепция программы не подразумивает данный функционал
    $dateBlocks = explode("-", $date);

    if (count($dateBlocks) != 3) { // исключаем некоректный ввод даты вроде(ДД.ММ.ГГГГ или ДД/ММ/ГГГГ и т.д)
        return false;
    } else {
        $day = (int) date('d');
        $month = (int) date('m');
        $year = (int) date('Y');
        if ($dateBlocks[2] > $year || $dateBlocks[2] < 1){ // исключаем ввод пользователя меньше 1 и больше нынешнего года
            return false;
        }else{
            if ($dateBlocks[1] > 12 || $dateBlocks[1] < 1){ // исключаем ввод пользователя меньше 1 и больше 12
                return false;
            }else{
                if ($dateBlocks[2] == $year && $dateBlocks[1] > $month) { // исключаем ввод пользователя больше нынешнего месяца нынешнего года
                    return false;
                } else {
                   if (($dateBlocks[2] == $year && $dateBlocks[1] == $month) && $dateBlocks[0]>$day = (int) date('d')) { // исключаем ввод пользователя большего дня нынешнего месяца, нынешнего года
                    return false;
                   } else {
                    if ($dateBlocks[0] < 1) {// проверка на ввод отрицательных или 0 значений
                        return false;
                    }else if((($dateBlocks[1] % 2) == 0) && $dateBlocks[0] > 30) { // проверка на четность месяца и корректный ввод дней
                        return false;
                    }else if((($dateBlocks[1] % 2) != 0) && $dateBlocks[0] > 31) {// проверка на не четность месяца и корректный ввод дней
                        return false;
                    }else if(($dateBlocks[1] == 2) && $dateBlocks[0] > 28) {// проверка на  корректный ввод дней в феврале не в высокостный год
                        return false;
                    }else if((($dateBlocks[1] == 2) && $dateBlocks[0] > 29 ) && (($dateBlocks[2] % 4) == 0)) {// проверка на  корректный ввод дней в феврале в высокостный год
                        return false;
                    }else{
                        return true;
                    }
                    
                }
            }
        }
    }
}

    
}
