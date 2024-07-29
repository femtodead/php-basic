<?php
$a = 5;
$b = '05';
var_dump($a == $b);
var_dump((int)'012345');
var_dump((float)123.0 === (int)123.0);
var_dump(0 == 'hello, world');
$a = 1;
$b = 2;
var_dump($a,$b);
$a = $a + $b; 
$b = $a - $b; 
$a = $a - $b;
var_dump($a,$b);
?>
<!-- версия 8.2:
bool(true) возвращает правду т.к двойное ровно (нестрогое сравнение), тоесть сначало идет преобразования типов только потом сравнение соответственно 5 == 5
int(12345) тут явное преобразование, поэтому строка превратилась в число 12345
bool(false) тут три ровно (строгое сравнение) поэтому сравнивается и тип , дробное число != целому поэтому лож
bool(false) тут все логично 
версия 7.4:
bool(true)
int(12345)
bool(false)
bool(true)  Как я понял , в версии 7.4 были старые правила приведения типов , раньше если строка не начиналась с числа то она приводила строку к 0 соответственно 0 == 0 
поэтому и  true, в 8.2 это поменяли поэтому там результат false


$a = 1;
$b = 2;
var_dump($a,$b);
$a = $a + $b; 
$b = $a - $b; 
$a = $a - $b;
var_dump($a,$b);

результат:
int(1)
int(2)
int(2)
int(1) -->