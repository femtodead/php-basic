<?php

namespace Geekbrains\Application1\Application;

use Exception;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class Render {

    private string $viewFolder = '/src/Domain/Views/';
    private FilesystemLoader $loader;
    private Environment $environment;


    public function __construct(){
        $this->loader = new FilesystemLoader($_SERVER['DOCUMENT_ROOT'] . $this->viewFolder);
        $this->environment = new Environment($this->loader, [
            'cache' => $_SERVER['DOCUMENT_ROOT'].'/cache/',
        ]);
    }

    public function renderPage(string $contentTemplateName = 'page-index.tpl', array $templateVariables = []) {
        $template = $this->environment->load('main.tpl');
        
        $templateVariables['content_template_name'] = $contentTemplateName;
 
        return $template->render($templateVariables);
    }

    public static function renderExceptionPage(Exception $exception): string {
        // Устанавливаем имя шаблона для отображения ошибки
        $contentTemplateName = "error.tpl";
        
        // Указываем папку с представлениями
        $viewFolder = '/src/Domain/Views/';
    
        // Создаем загрузчик файловой системы для шаблонов
        $loader = new FilesystemLoader($_SERVER['DOCUMENT_ROOT'] . $viewFolder);
        
        // Создаем экземпляр окружения Twig с указанием кэша
        $environment = new Environment($loader, [
            'cache' => $_SERVER['DOCUMENT_ROOT'].'/cache/',
        ]);
    
        // Загружаем основной шаблон
        $template = $environment->load('main.tpl');
        
        // Подготавливаем переменные для шаблона
        $templateVariables['content_template_name'] = $contentTemplateName; // Имя шаблона для контента
        $templateVariables['error_message'] = $exception->getMessage(); // Сообщение об ошибке из исключения
     
        // Рендерим шаблон с переданными переменными и возвращаем результат
        return $template->render($templateVariables);
    }
}