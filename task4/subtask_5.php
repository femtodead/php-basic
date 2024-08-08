<?php

abstract class Book {
    protected string $title; // название
    protected string $author; // автор
    protected int $readCount; // количество прочтений 

    public function __construct(string $title, string $author) { // конструтор принает атора и название , при этом количество прочтенй всегда при создание экземпляра падает в 0
        $this->title = $title;
        $this->author = $author;
        $this->readCount = 0;
    }

    public function getTitle(): string {
        return $this->title;
    }

    public function getAuthor(): string {
        return $this->author;
    }

    public function getReadCount(): int {
        return $this->readCount;
    }



    abstract public function BookIssuance(): string; // создаем абстрактный метод но не описываем его так как в дочерних класах он будет возвращать разные вещи(можно также реализовать через интерфес)
}

class DigitalBook extends Book {
    private string $downloadLink;

    public function __construct(string $title, string $author, string $downloadLink) { // конструктор принимает параметры как и в родительском классе + ссылка на скачивание 
        parent::__construct($title, $author);
        $this->downloadLink = $downloadLink;
    }

    public function getDownloadLink(): string {
        return $this->downloadLink;
    }

    public function BookIssuance(): string {// каждая выдача книги увеличивает количиство прочтений на 1
        $this->readCount++;
        return "Ссылка для скачивания: " . $this->downloadLink;
    }
}

class PhysicalBook extends Book {
    private string $libraryAddress;

    public function __construct(string $title, string $author, string $libraryAddress) { // конструктор принимает параметры как и в родительском классе + адрес библиотеки
        parent::__construct($title, $author);
        $this->libraryAddress = $libraryAddress;
    }

    public function getLibraryAddress(): string {
        return $this->libraryAddress;
    }

    public function BookIssuance(): string {// каждая выдача книги увеличивает количиство прочтений на 1
        $this->readCount++;
        return "Адрес библиотеки: " . $this->libraryAddress;
    }
}



$digitalBook = new DigitalBook("1984", "George Orwell", "http://example.com/1984");
echo $digitalBook->BookIssuance() . "\r\n"; 
echo "Количество прочтений: " . $digitalBook->getReadCount() . "\r\n"; 
echo $digitalBook->BookIssuance() . "\r\n"; 
echo "Количество прочтений: " . $digitalBook->getReadCount() . "\r\n"; 

$physicalBook = new PhysicalBook("To Kill a Mockingbird", "Harper Lee", "ул. Библиотечная, д. 1");
echo $physicalBook->BookIssuance() . "\r\n"; 
echo "Количество прочтений: " . $physicalBook->getReadCount() . "\r\n"; 