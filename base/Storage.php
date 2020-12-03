<?php

namespace app\base;


/**
 * Class Storage хранит информацию о компонентах приложения, запускаемых в app и запрашиваемых в единичном объекте на все приложение
 * @package app\base
 */
class Storage
{
    private $items = [];

    public function set($key, $object)
    {
        $this->items[$key] = $object;
    }

    public function get($key)
    {
        if(!isset($this->items[$key])){
            $this->items[$key] = App::call()->createComponent($key);
        }
        return $this->items[$key];
    }
}