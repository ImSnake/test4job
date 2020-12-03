<?php

namespace app\models;

use app\services\Db;

abstract class DataModel implements IModel
{
    private $db;

    public function __construct()
    {
        $this->db = Db::getInstance();
    }

    protected static function getDb(){
        return Db::getInstance();
    }


    /**
     * getOne - создание объекта по по id
     * @param $id
     * @return object
     */
    public static function getOneObj($id)
    {
        $table = static::getTableName();
        $sql = "SELECT * FROM {$table} WHERE id = :id";
        return static::getDb()->queryObject($sql, [':id' => $id], get_called_class());
    }

    /**
     * getAll - создание массива объектов для всех строк таблицы из БД
     * @return array[objects]
     */
    public static function getAllObj()
    {
        $table = static::getTableName();
        $sql = "SELECT * FROM {$table}";
        return static::getDb()->queryObjects($sql, get_called_class());
    }

// =========================================================================================

// получить данные as array по sql запросу
    public static function getSqlValArr($sql)
    {
        return static::getDb()->queryAll($sql);
    }

// получить данные as object по sql запросу
    public static function getSqlValObj($sql, $param)
    {
        return static::getDb()->queryObject($sql, $param, get_called_class());
    }

//===========================================================================================
//CRUD
// определить действие для новых входящих данных: insert или update
    public function save()
    {
        if (is_null($this->id)) {
            return $this->insert();
        } else {
            return $this->update();
        }
    }

    /**
     *insert добавление в БД новых свойств объекта
     */
    public function insert()
    {
        $data = $this->getAllObjProp();
        $params = $data['params'];
        $placeholders = implode(", ", array_keys($params));
        $columns = implode(", ", array_values($data['columns']));

        $table = static::getTableName();
        //INSERT INTO cart (`id`, `created`, `order`, `user`) VALUES (:id, :created, :order, :user)'
        $sql = "INSERT INTO {$table} ({$columns}) VALUES ({$placeholders})";
        $this->db->execute($sql, $params);
        return $this->id = $this->db->lastInsertId();
    }

// Находит имена колонок в БД, но требует передачи в метод доп.аргументов\параметров с массивом новых значений
    public function create($params = [])
    {
        $table = static::getTableName();
        $columns = $this->getColumns($table);
        $values = implode(", ", $params);
        $sql = "INSERT INTO {$table} ({$columns}) VALUES ({$values})";
        return $this->db->execute($sql);
    }

    /**
     * update логика метода : 1. Получить массив со значениями объекта;
     * 2. Получить строку из бд по id;
     * 3. Сравнить значения массивов;
     * 4. Передать в БД массив изменений.
     */
    public function update()
    {
        $dbValue = $this->getOne($this->id)->getAllObjProp();
        $appValue = $this->getAllObjProp();
        $params = array_diff($appValue['params'], $dbValue['params']);

        $request = '';
        foreach ($params as $key => $value) {
            $request .= substr($key, 1) . " = {$key}" . ', ';
        }
        $request = substr($request, 0, -2);

        //UPDATE `gb_course_project`.`goods` SET `price` = '455.00', `discount` = '0.10' WHERE (`id` = '19');
        $table = static::getTableName();
        $sql = "UPDATE {$table} SET {$request} WHERE (id = '{$this->id}')";
        return $this->db->execute($sql, $params);
    }

    /**
     * delete - удаляет из БД строку с id объекта
     */
    public function delete()
    {
        $table = static::getTableName();
        $sql = "DELETE FROM {$table} WHERE id = {$this->id}";
        return $this->db->execute($sql);
    }

//=============================================================================================

// Получить все свойства и плейсхолдеры объекта массивом
    public function getAllObjProp()
    {
        $columns = [];
        $params = [];

        foreach ($this as $key => $value) {
            if (!is_object($value)) {
                $params[":{$key}"] = $value;
                $columns [] = "`{$key}`";
            }
        }
        return $result [] = ['params' => $params, 'columns' => $columns];
    }

// Получить имена колонок таблицы для выполнения команды insert
    public function getColumns($table)
    {
        $sql = "SELECT `COLUMN_NAME` FROM `INFORMATION_SCHEMA`.`COLUMNS` WHERE `TABLE_NAME`='{$table}'";
        $result = $this->db->queryAll($sql);
        $columns = ``;
        foreach ($result as $value) {
            foreach ($value as $find) {
                if ($find !== 'id' & $find !== 'created') {
                    $columns .= $find . ", ";
                }
            }
        }
        return substr($columns, 0, -2);
    }




}
