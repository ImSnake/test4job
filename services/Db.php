<?php

namespace app\services;


class Db implements IDb
{
    private $config = [];

    public function __construct($driver, $host, $login, $password, $database, $charset = "utf8")
    {
        $this->config['driver'] = $driver;
        $this->config['host'] = $host;
        $this->config['login'] = $login;
        $this->config['password'] = $password;
        $this->config['database'] = $database;
        $this->config['charset'] = $charset;
    }

    protected $conn = null;

// устанавливает соединение с БД
    protected function getConnection()
    {
        if (is_null($this->conn)) {
            $options = [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
            ];

            $this->conn = new \PDO(
                $this->prepareDsnString(),
                $this->config['login'],
                $this->config['password'],
                $options
            );
            // не удачное решение, так как теперь все значения возвращаются в виде объектов...
            $this->conn->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
        }
        return $this->conn;
    }

// создает объект PDO для подключения к БД
    private function query($sql, $params = [])
    {
        /** @var \PDOStatement $pdoStatement */
        $pdoStatement = $this->getConnection()->prepare($sql);
        $pdoStatement->execute($params);
        return $pdoStatement;
    }

// возвращает один объект с именем класса, вызвавшего метод
    public function queryObject($sql, $params, $class)
    {
        $smtp = $this->query($sql, $params);
        $smtp->setFetchMode(\PDO::FETCH_CLASS, $class);
        return $smtp->fetch();
    }

// возвращает все объекты с именем класса, вызвавшего метод
    public function queryObjects($sql, $class)
    {
        $smtp = $this->query($sql);
        $smtp->setFetchMode(\PDO::FETCH_CLASS, $class);
        return $smtp->fetchAll();
    }

// возвращает массив с данными запроса
    public function queryOne(string  $sql, $params = [])
    {
        return $this->queryAll($sql, $params)[0];
    }

// возвращает массив массивов со всеми данными запроса
    public function queryAll(string $sql, $params = [])
    {
        $result = $this->query($sql, $params)->fetchAll();
        return $result;
    }

// выполняет update таблицы БД
    public function execute($sql, $params = [])
    {
        $this->query($sql, $params);
    }

// возвращает значение последненго id , добавленного в БД
    public function lastInsertId(){
        return $this->getConnection()->lastInsertId();
    }

// подготавливает запрос на подключение к БД
    private function prepareDsnString(): string
    {
        return sprintf("%s:host=%s;dbname=%s;charset=%s",
            $this->config['driver'],
            $this->config['host'],
            $this->config['database'],
            $this->config['charset']
        );
    }
}