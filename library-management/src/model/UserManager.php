<?php

require_once __DIR__ . '/../utils/Constant.php';
require_once __DIR__ . '/./User.php';

class UserManager{

    private $db;

    public function __construct($dbConnection){
        if ($dbConnection instanceof \mysqli) {
            $this->db = $dbConnection;
        } else {
            throw new \Exception('Connection injected is not a Mysqli object');
        }
        \session_start();
    }

    public function login($email, $password){
        $user = $this->findUserByEmailAndPassword($email, $this->getHash($password));
        if ($user) {
            $_SESSION["current_user"] = $user;
            return true;
        } else {
            return false;
        }
    }

    public function findUserByEmailAndPassword($email, $hashedPassword){
        $query = "SELECT user.* FROM user WHERE "
                . "user.email = '%s' AND user.password = '%s' AND status = "
                . USER_ACTIVE;
        $query = \sprintf($query, $this->db->real_escape_string($email), $hashedPassword);
        if ($result = $this->db->query($query)) {
            $row = $result->fetch_assoc();
            if (!$row) {
                return false;
            }
            $user = new User($row["user_id"], $row["email"], null, $row["name"], 
                    $row["ic_number"], $row["phone"], $row["date_of_birth"], 
                    $row["address"], $row["type"], 
                    null, null, null, null, null);
            $result->close();
        } else {
            die($this->db->error);
        }
        return $user;
    }

    public function logout(){
        unset($_SESSION["current_user"]);
        return true;
    }

    public function isLoggedIn(){
        if (isset($_SESSION["current_user"]) && $_SESSION["current_user"]){
            return $_SESSION["current_user"];
        }
        return false;
    }


    private function getHash($password){
        return \hash("sha256", $this->db->real_escape_string($password));
    }

}