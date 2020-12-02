<?php

require_once __DIR__ . '/../utils/Constant.php';
require_once __DIR__ . '/../utils/StringUtils.php';
require_once __DIR__ . '/../utils/DateUtils.php';
require_once __DIR__ . '/./User.php';

class UserManager{

    private $db;

    public function __construct($dbConnection){
        if ($dbConnection instanceof \mysqli) {
            $this->db = $dbConnection;
        } else {
            throw new \Exception('Connection injected is not a Mysqli object');
        }
    }
    
    public function checkExistingEmailCreate($email){
        $query = "SELECT count(*) FROM user WHERE "
                . "email = '%s'";
        $query = \sprintf($query, mysql_real_escape_string($email));
        $result=mysql_query($query);
        if (mysql_fetch_assoc($result)["total"] != 0){
            return true;
        }
        return false;
    }
    
    public function checkExistingEmailUpdate($email, $userId){
        $query = "SELECT count(*) FROM user WHERE "
                . "email = '%s' AND user_id != '%d'";
        $query = \sprintf($query, mysql_real_escape_string($email), $userId);
        $result=mysql_query($query);
        if (mysql_fetch_assoc($result)["total"] != 0){
            return true;
        }
        return false;
    }
    
    public function checkExistingPhoneCreate($phone){
        $query = "SELECT count(*) FROM user WHERE "
                . "user.phone = '%s'";
        $query = \sprintf($query, mysql_real_escape_string($phone));
        $result=mysql_query($query);
        if (mysql_fetch_assoc($result)["total"] != 0){
            return true;
        }
        return false;
    }
    
    public function checkExistingPhoneUpdate($phone, $userId){
        $query = "SELECT count(*) FROM user WHERE "
                . "phone = '%s' AND user_id != '%d'";
        $query = \sprintf($query, mysql_real_escape_string($phone), $userId);
        $result=mysql_query($query);
        if (mysql_fetch_assoc($result)["total"] != 0){
            return true;
        }
        return false;
    }

    public function findUserByEmailAndPassword($email, $hashedPassword){
        $query = "SELECT * FROM user WHERE "
                . "email = '%s' AND password = '%s' AND status = " . USER_ACTIVE;
        $query = \sprintf($query, $email, $hashedPassword);
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
//            die($this->db->error);
            return false;
        }
        return $user;
    }
    
    public function findAllUsers($page, $pageSize, $sortBy, $sortOrder){
        $users = [];
        $query = "SELECT * FROM user"
                . " WHERE status = " . strval(USER_ACTIVE)
                . (unserialize($_SESSION["current_user"])->getType() == EMPLOYEE_ROLE ? " and type = " . strval(USER_ROLE) : "")
                . " ORDER BY " . $sortBy . " " . $sortOrder . " LIMIT " . 
                strval(($page-1)*$pageSize) . ", " . strval($pageSize);
        $result = $this->db->query($query);
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $users[] = new User($row["user_id"], 
                        $row["email"], 
                        null, 
                        $row["name"], 
                        $row["ic_number"], 
                        $row["phone"], 
                        $row["date_of_birth"], 
                        $row["address"], 
                        $row["type"], 
                        $row["status"], 
                        $row["insert_date"], 
                        $row["insert_by"], 
                        $row["update_date"], 
                        $row["update_by"]);
            }
            $result->close();
        } else {
            echo($this->db->error);
        }
        return $users;
    }


    public function findUserById($userId){
        $query = "SELECT * FROM user "
                . "WHERE user_id = '%s'"
                . (unserialize($_SESSION["current_user"])->getType() == EMPLOYEE_ROLE ? " and type = " . strval(USER_ROLE) : "");
        $query = sprintf($query, $this->db->real_escape_string($userId));
        if ($result = $this->db->query($query)) {
            $row = $result->fetch_assoc();
            $user = new User($row["user_id"], 
                        $row["email"], 
                        null, 
                        $row["name"], 
                        $row["ic_number"], 
                        $row["phone"], 
                        $row["date_of_birth"], 
                        $row["address"], 
                        $row["type"], 
                        $row["status"], 
                        $row["insert_date"], 
                        $row["insert_by"], 
                        $row["update_date"], 
                        $row["update_by"]);
            $result->close();
        } else {
            die($this->db->error);
        }
        return $user;
    }
    
    public function addUser($user){
        $query = "INSERT INTO user (
              `email`, `password`, `name`, `ic_number`, `phone`, 
              `date_of_birth`, `address`, `type`, `status, 
              `insert_date`, `insert_by`, `update_date`, `update_by`
            )
            VALUES (
              '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%d', %d, 
              NOW(), %d, NOW(), %d
            )";
        $query = \sprintf($query, 
                $this->db->real_escape_string($user->getEmail()), 
                $this->db->real_escape_string(encryptPassword($user->getPassword())), 
                $this->db->real_escape_string($user->getName()),
                $this->db->real_escape_string($user->getIcNumber()),
                $this->db->real_escape_string($user->getPhone()),
                $this->db->real_escape_string(getDateForDatabase($user->getDateOfBirth())),
                $this->db->real_escape_string($user->getAddress()),
                $unserialize(_SESSION["current_user"])->getType() == EMPLOYEE_ROLE ? strval(USER_ROLE) : $this->db->real_escape_string($user->getType()),
                USER_ACTIVE,
                unserialize($_SESSION["current_user"])->getUserId(),
                unserialize($_SESSION["current_user"])->getUserId());
        if ($result = $this->db->query($query)) {
            return true;
        } else {
            die($this->db->error);
        }
    }
    
    public function editUser($user){
        $query = "UPDATE user SET "
                . (is_null($user->getEmail()) ? "" : ("email = " . mysql_real_escape_string($user->getEmail()) . ", "))
                . (is_null($user->getPassword()) ? "" : ("password = " . encryptPassword($user->getPassword()) . ", "))
                . (is_null($user->getName()) ? "" : ("name = " . mysql_real_escape_string($user->getName()) . ", "))
                . (is_null($user->getIcNumber()) ? "" : ("ic_number = " . mysql_real_escape_string($user->getIcNumber()) . ", "))
                . (is_null($user->getPhone()) ? "" : ("phone = " . mysql_real_escape_string($user->getPhone()) . ", "))
                . (is_null($user->getDateOfBirth()) ? "" : ("date_of_birth = " . mysql_real_escape_string($user->getDateOfBirth()) . ", "))
                . (is_null($user->getAddress()) ? "" : ("address = " . mysql_real_escape_string($user->getAddress()). ", "))
                . (!is_null($user->getType() && unserialize($_SESSION["current_user"])->getType() == ADMIN_ROLE) ? 
                ("type = " . mysql_real_escape_string($user->getType()). ", ") : "")
                . "update_date = NOW(), "
                . "update_by = " . strval(unserialize($_SESSION["current_user"])->getUserId())
                . " WHERE user_id = " . strval($user->getUserId());
        if ($result = $this->db->query($query)) {
            return true;
        } else {
            die($this->db->error);
        }
    }

    public function deleteUser($userId){
        $query = "UPDATE user SET "
                . "status = " . USER_DELETED . ", "
                . "update_date = NOW(), "
                . "update_by = " . strval(unserialize($_SESSION["current_user"])->getUserId())
                . " WHERE user_id = " . strval($userId);
        if ($result = $this->db->query($query)) {
            return true;
        } else {
            die($this->db->error);
        }
    }

}