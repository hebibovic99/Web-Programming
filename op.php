<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("rest/dao/StudentsDao.class.php");

$dao = new StudentsDao();

$op = $_REQUEST["op"];

switch($op){
    case 'insert':
        $FirstName = $_REQUEST['FirstName'];
        $LastName = $_REQUEST['LastName'];
        $dao->add($FirstName, $LastName);
        break;

     case 'delete':
        $id = $_REQUEST["id"];
        $dao->delete($id);
        echo "DELETED $id";
         break;

    case 'update':
        $id = $_REQUEST["id"];
        $FirstName = $_REQUEST["FirstName"];
        $Grade = $_REQUEST["Grade"];
        $dao->update($id, $FirstName, $Grade);
        echo "Updated $id";
        break;

    case 'get':
    default:
      $results = $dao->get_all();
      print_r($results);
      break;

}

?>