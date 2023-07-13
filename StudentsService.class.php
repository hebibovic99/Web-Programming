<?php

require_once './dao/StudentsDao.class.php';

class StudentsService
{
    private $studentdao;

    public function __construct()
    {
        $this->studentdao = new StudentsDao();
    }

    public function addStudents($FirstName, $LastName, $Grade, $Description, $Nickname)
    {
        $result = $this->studentdao->addStudent($FirstName, $LastName, $Grade, $Description, $Nickname);
    }
}
?>





//https://web-project-azure.vercel.app/login.html