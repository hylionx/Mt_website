<?php

class Database
{
    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $table = "mt_website";
    public static $pdo = null;
    public function __construct()
    {
        try {
            self::$pdo = new \PDO('mysql:host=' . $this->host . ';dbname=' . $this->table.';charset=utf8mb4', $this->user, $this->pass, [
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                \PDO::ATTR_PERSISTENT => true,
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
                // \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4'
            ]);
            return self::$pdo;
        } catch (\PDOException $e) {
            die('Erreur lors de la connexion &agrave; la base de donn&eacute;es: ' . $e->getMessage());
            //die();
        }
    }
    public static function connect()
    {
        return self::$pdo;
    }
}