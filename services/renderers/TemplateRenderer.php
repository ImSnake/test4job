<?php

namespace app\services\renderers;

use app\base\App;

class TemplateRenderer implements IRenderer
{
    // подставляет значения php-запросов в html-теги и сохраняет все в буфер
    public function render($template, $params = [], $title = [])
    {
        ob_start(); // записывает данные в буфер (т.е. не дает include вывести данные на экран)
        extract($params);  // преобразует ассоциативный массив в переменные
        extract($title);

        include App::call()->config['templateDir'] . $template . ".php";
        return ob_get_clean(); // передает данные из буфера и очищает его
    }
}