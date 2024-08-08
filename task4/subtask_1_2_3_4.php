<?php
// 1. Придумайте класс, который описывает любую сущность из предметной области библиотеки: книга, шкаф, комната и т.п.



class Closet{
    const MAX_BOOKS = 10;
    private array $books = [];

    public function __construct(array $initialBooks = []){
        if (!empty($initialBooks)) {
            foreach ($initialBooks as $book) {
                $this->addBook($book);
            }
        }
    }
    public function addBook(string $book) {
        if (count($this->books) < self::MAX_BOOKS) {
            $this->books[] = $book;
            echo "Книга '$book' добавлена в шкаф.\n";
        } else {
            echo "Шкаф полон, невозможно добавить книгу '$book'.\n";
        }
    }
    public function pickUpBook(String $book) : String | null {
        if (in_array( $book, $this->$books)) {
            $key =  array_search($book, $this->$books);
            $elem = $this->$books[$key];
            unset($books[$key]);
            $this->$books = array_values($this->$books);
            return $elem;
        } else {
            echo "Нет такой книги в шкафу возвращаю null";
            return null;
        }
        
    }
    public function getBooks(): array {
        return $this->books;
    }
}


class MilitaryCloset extends Closet { // шкаф с военной литиратурой 
    private array $militaryBooks = [
        "The Art of War",
        "On War",
        "The Face of Battle",
        "The Guns of August",
        "Band of Brothers"
    ]; // Список книг которые можно считать военными

    public function addBook(string $book) {
        if (in_array($book, $this->militaryBooks)) {
            parent::addBook($book);
        } else {
            echo "Книга '$book' не является военной литературой и не может быть добавлена.\n";
        }
    }
}

// Пример использования
$militaryCloset = new MilitaryCloset();
$Closet = new Closet();
$Closet->addBook("The Art of War"); // Будет добавлена
$Closet->addBook("The Catcher in the Rye"); // Будет добавлена
$militaryCloset->addBook("The Art of War"); // Будет добавлена
$militaryCloset->addBook("The Catcher in the Rye"); // Не будет добавлена

print_r($Closet->getBooks()); // Вывод текущих книг в шкафу
print_r($militaryCloset->getBooks()); // Вывод текущих книг в шкафу с военной литературой