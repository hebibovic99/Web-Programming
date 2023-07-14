<?php
require_once "./dao/BaseDao.class.php";

class StudentsDao extends BaseDao {
  public function __construct() {
    parent::__construct('students');
}

public function getAllStudents() {
  $stmt = $this->conn->prepare("SELECT * FROM students");
  $stmt->execute();
  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function get_by_idStudent($id){
  $stmt = $this->conn->prepare("SELECT * FROM students WHERE id = :id");
  $stmt->execute(['id' => $id]);
  return reset($result);
}

  public function addStudent($FirstName, $LastName, $Grade, $Description, $Nickname) {
    $stmt = $this->conn->prepare("INSERT INTO students (FirstName, LastName, Grade, Description, Nickname) VALUES (:FirstName, :LastName , :Grade, :Description, :Nickname)");
    $stmt->execute([':FirstName' => $FirstName, ':LastName' => $LastName, ':Grade' => $Grade, ':Description' => $Description, ':Nickname' => $Nickname]);
  }

  public function deleteStudent($id) {
    $stmt = $this->conn->prepare("DELETE FROM students WHERE id=:id"); 
    $stmt->bindParam(':id', $id);
    $stmt->execute();
  }

  
  public function updateStudent($id, $data) {
    $FirstName = $data['FirstName'];
    $LastName = $data['LastName'];
    $Grade = $data['Grade'];
    $Description = $data['Description'];

    $stmt = $this->conn->prepare("UPDATE students SET FirstName = ?, Grade = ?, LastName = ?, Description = ? WHERE id = ?");
    $stmt->execute([$FirstName, $Grade, $LastName, $id, $Description]);

    return $stmt->rowCount() > 0;
}

 }

?>
