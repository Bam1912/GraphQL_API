<?php

namespace App;

use PDO;

/**
 * Class Db
 */
class DB
{
    /**
     * Активное PDO соединение
    */
    private static $pdo;

    /**
     * Инициализация PDO соединения
     *
     * @param array $config
     */
    public static function init($config)
    {
        // Создаем PDO соединение
        self::$pdo = new PDO("mysql:host={$config['host']};dbname={$config['database']}", $config['username'], $config['password']);
        // Задаем режим выборки по умолчанию
        self::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        // self::$pdo->query("SET NAMES utf8");
    }

    /**
     * Выполнение запроса select и возвращение одной строки
     *
     * @param  string  $query
     * @return mixed
     */
    public static function selectOne($query)
    {
        $records = self::select($query);
        return array_shift($records);
    }

    /**
     * Выполнение запроса select и возвращение строк
     *
     * @param  string  $query
     * @return array
     */
    public static function select($query)
    {
        $statement = self::$pdo->query($query);
        return $statement->fetchAll();
    }

    /**
     * Выполнение запроса и возвращение количества затронутых строк
     *
     * @param  string  $query
     * @return int
     */
    public static function affectingStatement($query)
    {
        $statement = self::$pdo->query($query);
        return $statement->rowCount();
    }

    /**
     * Выполнение запроса update и возвращение количества затронутых строк
     *
     * @param  string  $query
     * @return int
     */
    public static function update($query)
    {
        $statement = self::$pdo->prepare($query);
        $statement->execute();
        return $statement->rowCount();
    }

    /**
     * Выполнение запроса insert и возвращение id последней записи в случае успеха
     *
     * @param  string  $query
     * @return int
     */
    public static function insert($query)
    {
        $statement = self::$pdo->prepare($query);
        $statement->execute();
        return self::$pdo->lastInsertId();
        //return $success ? self::$pdo->lastInsertId() : null;
    }
/**
     * Выполнение запроса delete и возвращение количества затронутых строк
     *
     * @param  string  $query
     * @return int
     */
    public static function delete($query)
    {
        $stmt = self::$pdo->prepare($query);
        $stmt->execute();
        return $stmt->rowCount();
    }
}
