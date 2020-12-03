<?php
namespace app\traits;

/**
 * @ использовать объект в едином экземпляре
 */
trait TSingleton
{
    private static $instance;

    private function __construct() {}

    private function __clone() {}

    public static function getInstance(){
        if(is_null(static::$instance)){
            static::$instance = new static();
        }
        return static::$instance;
    }
}