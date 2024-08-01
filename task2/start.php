<?php
// 1. Реализовать основные 4 арифметические операции в виде функции с тремя параметрами – два параметра это числа, третий – операция. Обязательно использовать оператор return.

// 2. Реализовать функцию с тремя параметрами: function mathOperation($arg1, $arg2, $operation), где $arg1, $arg2 – значения аргументов, $operation – строка с названием операции. В зависимости от переданного значения операции выполнить одну из арифметических операций (использовать функции из пункта 3) и вернуть полученное значение (использовать switch).
    function mathOperation($arg1, $arg2, $operation)
    {
        if (is_numeric($arg1) && is_numeric($arg2))   {
           switch ($operation) {
            case '-':
                return $arg1 - $arg2;
            case '+':
                return $arg1 + $arg2;
            case '*':
                return $arg1 * $arg2;
            case '/':
                if ($arg2 == 0) {
                    echo "на 0 делить нельзя, возращаю -1 \n";
                    return -1;
                }else{
                    return $arg1 / $arg2;
                }
            default:
                echo "В данной функции можно использовать 4 операции - + * /, возращаю -1\n";
                return -1;
           }
        } else{
            echo "Один из аргументов или оба не являются числом, возращаю -1\n";
            return -1;
        }
    };
    echo mathOperation('1',0.25, '+');
    echo "\n";
    echo mathOperation('1','0.25', '-');
    echo "\n";
    echo mathOperation(1,'0.25', '/');
    echo "\n";
    echo mathOperation(1,0.25, '*');
    echo "\n";
    echo mathOperation(1,'0', '/');
    echo "\n";
    echo mathOperation(1,'0.25', ':');
    echo "\n";
// 3. Объявить массив, в котором в качестве ключей будут использоваться названия областей, а в качестве значений – массивы с названиями городов из соответствующей области. Вывести в цикле значения массива, чтобы результат был таким: Московская область: Москва, Зеленоград, Клин Ленинградская область: Санкт-Петербург, Всеволожск, Павловск, Кронштадт Рязанская область … (названия городов можно найти на maps.yandex.ru).
    $citiesAndRegions = array(
        "Московская область" => ["Москва", "Зеленоград", "Химки", "Подольск"],
        "Ленинградская область" => ["Санкт-Петербург", "Выборг", "Гатчина", "Всеволожск"],
        "Свердловская область" => ["Екатеринбург", "Нижний Тагил", "Каменск-Уральский", "Первоуральск"],
        "Краснодарский край" => ["Краснодар", "Сочи", "Новороссийск", "Анапа"],
        "Новосибирская область" => ["Новосибирск", "Бердск", "Искитим", "Куйбышев"],
        "Республика Татарстан" => ["Казань", "Набережные Челны", "Альметьевск", "Бугульма"],
        "Ростовская область" => ["Ростов-на-Дону", "Таганрог", "Шахты", "Новочеркасск"],
        "Самарская область" => ["Самара", "Тольятти", "Сызрань", "Новокуйбышевск"],
        "Челябинская область" => ["Челябинск", "Магнитогорск", "Златоуст", "Миасс"],
        "Приморский край" => ["Владивосток", "Находка", "Уссурийск", "Артем"]
    );
    foreach ($citiesAndRegions as $key => $value) {
        echo "\n".$key . ":";
        for ($i=0; $i < count($value); $i++) { 
            if ($i == 3) {
                echo " " . $value[$i] ;
            } else {
                echo " " . $value[$i] . ",";
            };
            
        };
    };

    // 4. Объявить массив, индексами которого являются буквы русского языка, а значениями – соответствующие латинские буквосочетания (‘а’=> ’a’, ‘б’ => ‘b’, ‘в’ => ‘v’, ‘г’ => ‘g’, …, ‘э’ => ‘e’, ‘ю’ => ‘yu’, ‘я’ => ‘ya’). Написать функцию транслитерации строк.
    $russianToLatin = [
        'а' => 'a',  'А' => 'A',
        'б' => 'b',  'Б' => 'B',
        'в' => 'v',  'В' => 'V',
        'г' => 'g',  'Г' => 'G',
        'д' => 'd',  'Д' => 'D',
        'е' => 'e',  'Е' => 'E',
        'ё' => 'yo', 'Ё' => 'Yo',
        'ж' => 'zh', 'Ж' => 'Zh',
        'з' => 'z',  'З' => 'Z',
        'и' => 'i',  'И' => 'I',
        'й' => 'y',  'Й' => 'Y',
        'к' => 'k',  'К' => 'K',
        'л' => 'l',  'Л' => 'L',
        'м' => 'm',  'М' => 'M',
        'н' => 'n',  'Н' => 'N',
        'о' => 'o',  'О' => 'O',
        'п' => 'p',  'П' => 'P',
        'р' => 'r',  'Р' => 'R',
        'с' => 's',  'С' => 'S',
        'т' => 't',  'Т' => 'T',
        'у' => 'u',  'У' => 'U',
        'ф' => 'f',  'Ф' => 'F',
        'х' => 'kh', 'Х' => 'Kh',
        'ц' => 'ts', 'Ц' => 'Ts',
        'ч' => 'ch', 'Ч' => 'Ch',
        'ш' => 'sh', 'Ш' => 'Sh',
        'щ' => 'shch','Щ' => 'Shch',
        'ъ' => '\'', 'Ъ' => '\'',
        'ы' => 'y',  'Ы' => 'Y',
        'ь' => '\'', 'Ь' => '\'',
        'э' => 'e',  'Э' => 'E',
        'ю' => 'yu', 'Ю' => 'Yu',
        'я' => 'ya', 'Я' => 'Ya',
        ' ' => ' '
    ];






    function Translit(string $word){ 
            global $russianToLatin;
            $translitWord = "\n";
            for ($i=0; $i < mb_strlen($word); $i++) { 
                if (array_key_exists(mb_substr($word,$i, 1), $russianToLatin)) {
                    $translitWord .= $russianToLatin[mb_substr($word,$i, 1)] ;
                } else {
                    $translitWord .= mb_substr($word,$i, 1);
                }
                
            }
            return $translitWord;      
    };
    echo Translit("Привeт мир");
    echo Translit("Привет мир 10-го поколения");
    // 5. *С помощью рекурсии организовать функцию возведения числа в степень. Формат: function power($val, $pow), где $val – заданное число, $pow – степень.
    function power($val,int $pow) {
        if ($pow == 1){
            return $val;
        }
        return $val * power($val,$pow-1);
    }
    echo "\n". power(2, 16). "\n";

    // 6. *Написать функцию, которая вычисляет текущее время и возвращает его в формате с правильными склонениями, например:
    // 22 часа 15 минут
    // 21 час 43 минуты.

    function sklonenie(int $number, $one, $two, $five) {
        $number = abs($number);
        $number1 = $number % 10;

        if ($number > 10 && $number < 20) {
            return $five;
        }
        if ($number1 > 1 && $number1 < 5) {
            return $two;
        }
        if ($number1 == 1) {
            return $one;
        }
        return $five;
    }
    function Gettime()  {
        $hours = (int) date('H')+3;
        $minutes = (int) date('i')+3;
        return $hours . ' ' . sklonenie($hours, "час", "часа", "часов") . ' ' . $minutes . ' ' . sklonenie($minutes, 'минута', 'минуты', 'минут') . "\n";
    }
    echo Gettime();
?>