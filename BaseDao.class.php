<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class BaseDao
{
    protected $conn;
    protected $table_name;

    public function __construct($table_name)
    {
        $this->table_name = $table_name;
        $servername = "db4free.net";
        $username = "ademir";
        $password = "ademir123";
        $database = "todobase";
        $port = "3306";
        $this->conn = new PDO("mysql:host=$servername;dbname=$database;port=$port", $username, $password);
    }

    /**
     * Method used to get all entities from the database
     */
    public function get_all()
    {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table_name");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Method used to get an entity by ID from the database
     */
    public function get_by_id($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM `$this->table_name` WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    /**
     * Method used to add an entity to the database
     */
    public function add($entity){
        $columns = implode(", ", array_keys($entity));
        $placeholders = ":" . implode(", :", array_keys($entity));

        $stmt = $this->conn->prepare("INSERT INTO $this->table_name ($columns) VALUES ($placeholders)");
        $stmt->execute($entity);
        $entity['id'] = $this->conn->lastInsertId();
        return $entity;
    }

    /**
    * Method used to update an entity in the database
    */
    public function update($entity, $id, $id_column = "id") {
        $setStatements = "";
        $params = [];
    
        foreach ($entity as $key => $value) {
            $setStatements .= "$key = :$key, ";
            $params[":$key"] = $value;
        }
        $setStatements = rtrim($setStatements, ", ");
    
        $params[":$id_column"] = $id;
    
        $query = "UPDATE $this->table_name SET $setStatements WHERE $id_column = :$id_column";
        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        
        return $entity;
    }

    /**
    * Method used to delete an entity from the database
    */
    public function delete($id){
        $stmt = $this->conn->prepare("DELETE FROM $this->table_name WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    /**
    * Method used to execute a generic query and fetch multiple rows
    */
    protected function query($query, $params){
        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
    * Method used to execute a generic query and fetch a single row
    */
    protected function query_unique($query, $params){
        $results = $this->query($query, $params);
        return reset($results);
    }
}

?>