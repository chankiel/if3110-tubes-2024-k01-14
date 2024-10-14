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
    private PDO $pdo;

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

    // Langsung query mentah, jangan untuk input user
    // Cth: query("SELECT * FROM USERS")
    public function query($sql) {
        $result = $this->pdo->query($sql)->fetchAll();
        return $result;
    }

    /*
        prepareQuery(
         "SELECT * FROM :table WHERE id = :id",
         ['id'=>5]
        )
    */
    // Query dengan input user
    public function prepareQuery($sql, $params=[]) {
        try{
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll();
        }catch(PDOException $e){
            die("Error prepare query :".$e->getMessage());
        }
    }

    /*
        insert(
         "users",
         ['name'=>"labpro"]
        )
    */
    public function insert($table,$data){
        $columns = implode(", ",array_keys($data));
        $placeholders = ":". implode(", :",array_keys($data));

        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";

        try{
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($data);
            return $this->pdo->lastInsertId();
        }catch(PDOException $e){
            die("Error insert: ".$e->getMessage());
        }
    }

    /* 
        update(
         "users",
         ['name'=>'labpro'],
         "email=:email',
         ['email'=>'a@gmail.com']
        )
    */
    public function update($table, $data, $condition, $params = []) {
        $fields = "";
        foreach ($data as $key => $value) {
            $fields .= "$key = :new_$key, ";
        }
        $fields = rtrim($fields, ", "); 
    
        $sql = "UPDATE $table SET $fields WHERE $condition";
    
        try {
            $stmt = $this->pdo->prepare($sql);
            foreach ($data as $key => $value) {
                $stmt->bindValue(":new_$key", $value);
            }
            foreach ($params as $key => $value) {
                $stmt->bindValue(":$key", $value); 
            }
            $stmt->execute();    
            return $stmt->rowCount();
    
        } catch (PDOException $e) {
            die("Error updating data: " . $e->getMessage());
        }
    }
    
    /*
        delete(
         "users",
         "id = :id",
         ["id"=>1],
        )
    */
    public function delete($table, $condition, $params=[]){
        $sql = "DELETE FROM $table WHERE $condition";
        try{
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->rowCount();
        }catch(PDOException $e){
            die("Error delete: ".$e->getMessage());
        }
    }

    /*
        findById(
         "users",
         1,
        )
    */
    public function findById($table, $id) {
        $sql = "SELECT * FROM $table WHERE id = :id";
        
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['id' => $id]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            die("Error fetching data: " . $e->getMessage());
        }
    }
    

    public function beginTransaction() {
        $this->pdo->beginTransaction();
    }
    
    public function commit() {
        $this->pdo->commit();
    }
    
    public function rollBack() {
        $this->pdo->rollBack();
    }
}
