<?php

require_once './dao/StudentInfoDao.class.php';

class StudentInfoService {
    private $studentsInfoDao;

    public function __construct() {
        $this->studentsInfoDao = new StudentInfoDao();
    }

    public function getAllStudents() {
        return $this->studentsInfoDao->getAllStudents();
    }
}
?>
