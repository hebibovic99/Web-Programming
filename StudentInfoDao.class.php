<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once "./dao/BaseDao.class.php";

class StudentInfoDao extends BaseDao
{
    public function __construct()
    {
        parent::__construct('students_info');
    }

    public function getAllStudents()
    {
        $stmt = $this->conn->prepare("SELECT * FROM students_info");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>