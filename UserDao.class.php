<?php

require_once './dao/BaseDao.class.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
class UserDao extends BaseDao {
    public function __construct() {
        parent::__construct('users');
    }

    public function registerUser($firstName, $lastName, $email, $password) {
        // Prepare an SQL select statement to check if the user already exists
        $checkStmt = $this->conn->prepare("SELECT * FROM users WHERE email = :email");
        $checkStmt->bindParam(':email', $email);
        $checkStmt->execute();

        // If user already exists, return with a validation message
        if ($checkStmt->rowCount() > 0) {
            return "User already exists";
        }

        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Prepare an SQL insert statement
        $insertStmt = $this->conn->prepare("INSERT INTO users (first_name, last_name, email, password) VALUES (:firstName, :lastName, :email, :password)");

        // Bind the values to the statement
        $insertStmt->bindParam(':firstName', $firstName);
        $insertStmt->bindParam(':lastName', $lastName);
        $insertStmt->bindParam(':email', $email);
        $insertStmt->bindParam(':password', $hashedPassword);

        // Execute the statement
        $insertStmt->execute();

        // If registration is successful, return with a success message
        if ($insertStmt->rowCount() > 0) {
            return "Registration successful";
        } else {
            return "Registration failed";
        }
    }

    public function getUserByEmail($email) {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table_name WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function loginUser($email, $password) {
        // Check if the email is valid
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "Invalid email format";
        }
    
        // Prepare an SQL select statement to retrieve the user by email
        $selectStmt = $this->conn->prepare("SELECT * FROM users WHERE email = :email");
        $selectStmt->bindParam(':email', $email);
        $selectStmt->execute();
    
        // If user exists, verify the password
        if ($selectStmt->rowCount() > 0) {
            $user = $selectStmt->fetch(PDO::FETCH_ASSOC);
            $hashedPassword = $user['password'];
    
            if (password_verify($password, $hashedPassword)) {
                unset($user['password']);
                return array('message' => 'Login successful', 'user' => $user);
            } else {
                return "Invalid password";
            }
        } else {
            return "User not found";
        }
    }
}

?>
