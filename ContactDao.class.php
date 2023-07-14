<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once "./dao/BaseDao.class.php";

class ContactDao extends BaseDao {
    public function __construct() {
        parent::__construct('contacts');
    }

    public function saveContact($name, $email, $number, $subject) {
        $insertStmt = $this->conn->prepare("
            INSERT INTO contacts (name, email, number, subject)
            VALUES (:name, :email, :number, :subject)
        ");

        $insertStmt->bindParam(':name', $name);
        $insertStmt->bindParam(':email', $email);
        $insertStmt->bindParam(':number', $number);
        $insertStmt->bindParam(':subject', $subject);

        if ($insertStmt->execute()) {
            return "The message is stored in our database! Thanks for contacting us.";
        } else {
            return "Failed to save contact";
        }
    }
}

?>