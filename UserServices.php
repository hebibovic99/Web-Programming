<?php

require_once './dao/UserDao.class.php';
use Firebase\JWT\JWT;
class UserServices {
    private $userDao;

    public function __construct($pdo) {
        $this->userDao = new UserDao($pdo);
    }

    public function registerUser($firstName, $lastName, $email, $password) {
        return $this->userDao->registerUser($firstName, $lastName, $email, $password);
    }

    public function loginUser($email, $password) {
        $user = $this->userDao->getUserByEmail($email);
    
        if (!$user || !password_verify($password, $user['password'])) {
            throw new Exception("Invalid email or password.");
        }
    
        $jwt_secret = Config::JWT_SECRET(); 
        $payload = array(
            "user_id" => $user['id'],
            "email" => $user['email'],
           
        );
        $jwt = JWT::encode($payload, $jwt_secret, 'HS256');
    
        return $jwt;
    }
}

?>
