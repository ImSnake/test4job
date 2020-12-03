<?php

namespace app\models\repositories;

use app\models\DataEntity;
use  app\base\App;

abstract class Repository implements IRepository
{
    private $db;

    public function __construct()
    {
        $this->db = Repository::getDb();
    }

    protected static function getDb()
    {
        return App::call()->db;
    }


    /**
     * getOne - создание объекта по по id
     * @param $id
     * @return object
     */
    public function getOneObj($id)
    {
        $table = $this->getTableName();
        $sql = "SELECT * FROM {$table} WHERE id = :id";
        return $this->db->queryObject($sql, [':id' => $id], $this->getEntityClass());
    }

    /**
     * getAll - создание массива объектов для всех строк таблицы из БД
     * @return array[objects]
     */
    public function getAllObj()
    {
        $table = $this->getTableName();
        $sql = "SELECT * FROM {$table}";
        $this->db->queryObjects($sql, $this->getEntityClass());
        return $this->db->queryObjects($sql, $this->getEntityClass());
    }

// =========================================================================================

// получить данные as array по sql запросу
    public function getSqlValArr($sql)
    {
        return $this->db->queryAll($sql);
    }

// получить данные as object по sql запросу
    public function getSqlValObj($sql, $param)
    {
        return $this->db->queryObject($sql, $param, $this->getEntityClass());
    }

//======CRUD========CRUD=========CRUD==========CRUD===========CRUD==========CRUD====================

// определить действие для новых входящих данных: insert или update
    public function save(DataEntity $entyty)
    {
        if (is_null($entyty->id)) {
            return $this->insert($entyty);
        } else {
            return $this->update($entyty);
        }
    }

    /**
     *insert добавление в БД новых свойств объекта
     */
    public function insert($entyty)
    {
        $data = $this->getAllObjProp($entyty);
        $params = $data['params'];
        $placeholders = implode(", ", array_keys($params));
        $columns = implode(", ", array_values($data['columns']));

        $table = $this->getTableName();
        //INSERT INTO cart (`id`, `created`, `order`, `user`) VALUES (:id, :created, :order, :user)'
        $sql = "INSERT INTO {$table} ({$columns}) VALUES ({$placeholders})";
        $this->db->execute($sql, $params);
        return $entyty->id = $this->db->lastInsertId();
    }


    /**
     * update логика метода : 1. Получить массив со значениями объекта;
     * 2. Получить строку из бд по id;
     * 3. Сравнить значения массивов;
     * 4. Передать в БД массив изменений.
     */
    public function update($entyty)
    {
        $dbValue = $this->getOneObj($entyty->id)->getAllObjProp();
        $appValue = $this->getAllObjProp($entyty);
        $params = array_diff($appValue['params'], $dbValue['params']);

        $request = '';
        foreach ($params as $key => $value) {
            $request .= substr($key, 1) . " = {$key}" . ', ';
        }
        $request = substr($request, 0, -2);

        //UPDATE `gb_course_project`.`goods` SET `price` = '455.00', `discount` = '0.10' WHERE (`id` = '19');
        $table = $this->getTableName();
        $sql = "UPDATE {$table} SET {$request} WHERE (id = '{$entyty->id}')";
        return $this->db->execute($sql, $params);
    }

    /**
     * delete - удаляет из БД строку с id объекта
     */
    public function delete(DataEntity $entyty)
    {
        $table = $this->getTableName();
        $sql = "DELETE FROM {$table} WHERE id = {$entyty->id}";
        return $this->db->execute($sql);
    }

//=============================================================================================

// Получить все свойства и плейсхолдеры объекта массивом
    public function getAllObjProp($entity)
    {
        $columns = [];
        $params = [];

        foreach ($entity as $key => $value) {
            if (!is_object($value)) {
                $params[":{$key}"] = $value;
                $columns [] = "`{$key}`";
            }
        }
        return $result [] = ['params' => $params, 'columns' => $columns];
    }

//====UNUSED=======UNUSED==========UNUSED========UNUSED==========

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

// Находит имена колонок в БД, но требует передачи в метод доп.аргументов\параметров с массивом новых значений
    public function create($params = [])
    {
        $table = $this->getTableName();
        $columns = $this->getColumns($table);
        $values = implode(", ", $params);
        $sql = "INSERT INTO {$table} ({$columns}) VALUES ({$values})";
        return $this->db->execute($sql);
    }
}