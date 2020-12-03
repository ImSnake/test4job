<?php

namespace app\models\repositories;

interface IRepository
{
    public function getOneObj($id);
    public function getAllObj();
    public function getTableName();
    public function getEntityClass();
}