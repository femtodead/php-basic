<?php

// function readAllFunction(string $address) : string {
function readAllFunction(array $config) : string {
    $address = $config['storage']['address'];

    if (file_exists($address) && is_readable($address)) {
        $file = fopen($address, "rb");
        
        $contents = ''; 
    
        while (!feof($file)) {
            $contents .= fread($file, 100);
        }
        
        fclose($file);
        return $contents;
    }
    else {
        return handleError("Файл не существует");
    }
}

// function addFunction(string $address) : string {
function addFunction(array $config) : string {
    $address = $config['storage']['address'];

    $name = readline("Введите имя: ");
    $date = readline("Введите дату рождения в формате ДД-ММ-ГГГГ: ");
    $data = $name . ", " . $date . "\r\n";

    $fileHandler = fopen($address, 'a');

    if(fwrite($fileHandler, $data)){
        return "Запись $data добавлена в файл $address"; 
    }
    else {
        return handleError("Произошла ошибка записи. Данные не сохранены");
    }

    fclose($fileHandler);
}

// function clearFunction(string $address) : string {
function clearFunction(array $config) : string {
    $address = $config['storage']['address'];

    if (file_exists($address) && is_readable($address)) {
        $file = fopen($address, "w");
        
        fwrite($file, '');
        
        fclose($file);
        return "Файл очищен";
    }
    else {
        return handleError("Файл не существует");
    }
}

function helpFunction() {
    return handleHelp();
}

function readConfig(string $configAddress): array|false{
    return parse_ini_file($configAddress, true);
}

function readProfilesDirectory(array $config): string {
    $profilesDirectoryAddress = $config['profiles']['address'];

    if(!is_dir($profilesDirectoryAddress)){
        mkdir($profilesDirectoryAddress);
    }

    $files = scandir($profilesDirectoryAddress);

    $result = "";

    if(count($files) > 2){
        foreach($files as $file){
            if(in_array($file, ['.', '..']))
                continue;
            
            $result .= $file . "\r\n";
        }
    }
    else {
        $result .= "Директория пуста \r\n";
    }

    return $result;
}

function readProfile(array $config): string {
    $profilesDirectoryAddress = $config['profiles']['address'];

    if(!isset($_SERVER['argv'][2])){
        return handleError("Не указан файл профиля");
    }

    $profileFileName = $profilesDirectoryAddress . $_SERVER['argv'][2] . ".json";

    if(!file_exists($profileFileName)){
        return handleError("Файл $profileFileName не существует");
    }

    $contentJson = file_get_contents($profileFileName);
    $contentArray = json_decode($contentJson, true);

    $info = "Имя: " . $contentArray['name'] . "\r\n";
    $info .= "Фамилия: " . $contentArray['lastname'] . "\r\n";

    return $info;
}

// 2. Поиск по файлу. Когда мы научились сохранять в файле данные, нам может быть интересно не только чтение, но и поиск по нему. Например, нам надо проверить, кого нужно поздравить сегодня с днем рождения среди пользователей, хранящихся в формате:
function searchFunction(array $config): string  { // функция ищет нужную строку по дате и возвращает ее,для удобной проверки работ программы использовал такой формат, в коментариях я оставлю код как это подрузомивается из условия задачи
    $address = $config['storage']['address'];
    if (file_exists($address) && is_readable($address)) {
        $file = fopen($address, "rb");
        
        $date = readline("Введите дату рождения в формате ДД-ММ-ГГГГ: ");
        // $date = date('d').'-'.date('m').'-'.date('Y'); соттветсвенно при вызове search сформируется строка вида дд-мм-гггг

        while (!feof($file)) {
            $str = fgets($file);
            $strArr = explode(", ", $str);
            if (count($strArr)== 2) {
                if ($date."\r\n" == $strArr[1]) {

                    return $str;
                }
            }
        }
        
        fclose($file);

    }
    else {
        return "файла нет";
    }
}
// 3. Удаление строки. Когда мы научились искать, надо научиться удалять конкретную строку. Запросите у пользователя имя или дату для удаляемой строки. После ввода либо удалите строку, оповестив пользователя, либо сообщите о том, что строка не найдена.
function delFunction(array $config) : string {
    $address = $config['storage']['address'];
    if (file_exists($address) && is_readable($address)) {
        $file = fopen($address, "rb");
        
        $lineIndex =((int) readline("Введите номер строки: ")) - 1; // спрашивем у пользователя номер строки
        
        $count = 0; //сетчик для проверки наличия строки в будущем 
        $newArr = [];// масив с новыми данными
        $flag = true; //флаг для тойже проверки упомянутой выше
        while (!feof($file)) {
            if($count != $lineIndex){// бегаем по строкам чтобы записать нужные и отсеять удоляемую
                array_push($newArr, fgets($file));
            }else{
                fgets($file);
                $flag = false;
            }
            $count++;
        }


        

        if($flag){
            return 'Строка под данным номером не найдена используйте цифры от 1 до '.$count;// проверка на наличие строки
        }else{
            $file = fopen($address, "w+");// чистим файл и открываем для записи
            foreach ($newArr as $line) {
                fwrite($file, $line);
            }
            return 'Строка удалена';
        }
        fclose($file);
    }
    else {
        return "файла нет";
    }
}