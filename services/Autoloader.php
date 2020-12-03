<?php

namespace app\autoload;

class Autoloader
{
    /**
     * loadClass - поиск и подключение файла с классом по имени и namespace
     * @param $className - класс в пространстве имен
     * $filename - путь к файлу с классом
     */
    public function loadClass($className)
    {
        $className = str_replace((["app\\", "\\"]), [ROOT_DIR, DIRECTORY_SEPARATOR], $className);
        $className .= ".php";

        if (file_exists($className)){
          include $className;
        }
    }
}