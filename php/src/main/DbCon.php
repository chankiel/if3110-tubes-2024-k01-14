<?php

namespace Main;
use PDO;
use PDOException;

class DbCon {
    private $host;
    private $user;
    private $password;
    private $db;
    private $port;
    private $pdo;

    private static $instance = null;

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new DbCon();
        }
        return self::$instance;
    }

    private function __construct()
    {
        $this->host = getenv("POSTGRES_HOST");
        $this->user = getenv("POSTGRES_USER");
        $this->password = getenv("POSTGRES_PASSWORD");
        $this->db = getenv("POSTGRES_DB");
        $this->port = getenv("POSTGRES_PORT");

        try{
            $dsn = "pgsql:host=$this->host;dbname=$this->db;port=$this->port";
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];
            $this->pdo = new PDO($dsn,$this->user,$this->password, $options);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "Connect successfully";
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }

    public function query($sql) {
        $result = $this->pdo->query($sql)->fetchAll();
        if (!$result) {
            die("Error query: " . $this->pdo->errorInfo());
        }
        return $result;
    }
}
