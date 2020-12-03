<?php

namespace app\services;

interface IDb
{
    public function queryOne(string $sql, $params);
    public function queryAll(string $sql, $params);
}