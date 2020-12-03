<?php

namespace app\models\repositories;

use app\models\Tasks;

class TasksRepository extends Repository
{
    public function getTableName()
    {
        return 'tasks';
    }

    public function getEntityClass()
    {
        return Tasks::class;
    }

    //  Получить задачи из БД
    public function getTasks()
    {
        $table = $this->getTableName();
        $sql = "SELECT tasks.id, content, status, executor, email FROM {$table} inner join _task_status on tasks.status_id = _task_status.id inner join _task_executor on tasks.user_id = _task_executor.id ORDER BY tasks.id ASC ";
        return $this->getSqlValArr($sql);
    }

/*// Получить данные для одного товара
    public function getSortedGoods($category, $type = null)
    {
        if ($type == null) {
            $addType = '';
        } else {
            $addType = " AND type = '{$type}'";
        }
        //$table = static::getTableName();
        $sql = "select category, goods.id, title, type, brand, price, miniImage from goods_category inner join goods on goods.category_id = goods_category.id inner join goods_type on goods.type_id = goods_type.id inner join goods_brand on goods.brand_id = goods_brand.id WHERE category = '{$category}'{$addType} ORDER BY goods.arrivalDate DESC  LIMIT 9;";

        return $this->getSqlValArr($sql);
    }

// Получить данные для одного товара
    public function getOneGood($id)
    {
        $table = $this->getTableName();
        $sql = "select goods.id, category, type, brand, title, price, imageMain, description from {$table} inner join goods_category on goods.category_id = goods_category.id inner join goods_type on goods.type_id = goods_type.id inner join goods_brand on goods.brand_id = goods_brand.id WHERE goods.id = {$id}";
        return $this->getSqlValArr($sql);
    }

    public function getProductsByIds()
    {
    }*/

}