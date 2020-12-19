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
        $query = "SELECT count(user_id) FROM user WHERE email = ?";
        if (!$conn = $this->db->prepare($query)){
            return false;
        }
        $conn->bind_param("s", $email);
        $conn->execute();
        return $conn->get_result()->fetch_assoc()["count(user_id)"] != 0;
    }
    
    public function checkExistingEmailUpdate($email, $userId){
        $query = "SELECT count(user_id) FROM user WHERE email = ? AND user_id != ?";
        if (!$conn = $this->db->prepare($query)){
            return false;
        }
        $conn->bind_param("si", $email, $userId);
        $conn->execute();
        return $conn->get_result()->fetch_assoc()["count(user_id)"] != 0;
    }
    
    public function checkExistingPhoneCreate($phone){
        $query = "SELECT count(user_id) FROM user WHERE phone = ?";
        if (!$conn = $this->db->prepare($query)){
            return false;
        }
        $conn->bind_param("s", $phone);
        $conn->execute();
        return $conn->get_result()->fetch_assoc()["count(user_id)"] != 0;
    }
    
    public function checkExistingPhoneUpdate($phone, $userId){
        $query = "SELECT count(user_id) FROM user WHERE phone = ? AND user_id != ?";
        if (!$conn = $this->db->prepare($query)){
            return false;
        }
        $conn->bind_param("si", $phone, $userId);
        $conn->execute();
        return $conn->get_result()->fetch_assoc()["count(user_id)"] != 0;
    }
    
    public function checkExistingIcNumCreate($icNum){
        $query = "SELECT count(user_id) FROM user WHERE ic_number = ?";
        if (!$conn = $this->db->prepare($query)){
            return false;
        }
        $conn->bind_param("s", $icNum);
        $conn->execute();
        return $conn->get_result()->fetch_assoc()["count(user_id)"] != 0;
    }
    
    public function checkExistingIcNumUpdate($icNum, $userId){
        $query = "SELECT count(user_id) FROM user WHERE ic_number = ? AND user_id != ?";
        if (!$conn = $this->db->prepare($query)){
            return false;
        }
        $conn->bind_param("si", $icNum, $userId);
        $conn->execute();
        return $conn->get_result()->fetch_assoc()["count(user_id)"] != 0;
    }

    public function findUserByEmailAndPassword($email, $hashedPassword){
        $query = "SELECT * FROM user WHERE "
                . "email = ? AND password = ? AND status = " . USER_ACTIVE;
        if (!$conn = $this->db->prepare($query)){
            return false;
        }
        $conn->bind_param("ss", $email, $hashedPassword);
        $conn->execute();
        if ($result = $conn->get_result()) {
            $row = $result->fetch_assoc();
            if (is_null($row)) {
                return null;
            }
            $user = new User($row["user_id"], $row["email"], null, $row["name"], 
                    $row["ic_number"], $row["phone"], $row["date_of_birth"], 
                    $row["address"], $row["type"], $row["image"], 
                    null, null, null, null, null);
            $result->close();
            return $user;
        } else {
//            die($this->db->error);
            return null;
        }
    }
    
    public function findAllUsers($page, $pageSize, $sortBy, $sortOrder, 
            $keyword){
        $users = [];
        $query = "SELECT * FROM user"
                . " WHERE status = " . strval(USER_ACTIVE)
                . (unserialize($_SESSION["current_user"])->getType() == EMPLOYEE_ROLE ? " and type = " . strval(USER_ROLE) : "")
                . (is_null($keyword)?"":" and (email LIKE CONCAT('%',?,'%') OR"
                        . "name LIKE CONCAT('%',?,'%') OR"
                        . "phone LIKE CONCAT('%',?,'%'))")
                . " ORDER BY ? " . $sortOrder . " LIMIT " . 
                strval(($page-1)*$pageSize) . ", " . strval($pageSize);
//        echo $query;
        if (!$conn = $this->db->prepare($query)){
            return false;
        }
        if (is_null($keyword)){
            $conn->bind_param("s", $sortBy);
        } else {
            $conn->bind_param("ssss", $keyword, $keyword, $keyword, $sortBy);
        }
        $conn->execute();
        if ($result = $conn->get_result()) {
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
                        $row["image"],
                        $row["status"], 
                        $row["insert_date"], 
                        $row["insert_by"], 
                        $row["update_date"], 
                        $row["update_by"]);
            }
            $result->close();
            return $users;
        } else {
            return null;
        }
    }


    public function findUserById($userId){
        $query = "SELECT * FROM user "
                . "WHERE user_id = " . strval($userId)
                . (unserialize($_SESSION["current_user"])->getType() == EMPLOYEE_ROLE ? " and type = " . strval(USER_ROLE) : "");
        if ($result = $this->db->query($query)) {
            $row = $result->fetch_assoc();
            if (is_null($row)){
                return null;
            }
            $user = new User($row["user_id"], 
                        $row["email"], 
                        null, 
                        $row["name"], 
                        $row["ic_number"], 
                        $row["phone"], 
                        $row["date_of_birth"], 
                        $row["address"], 
                        $row["type"], 
                        $row["image"],
                        $row["status"], 
                        $row["insert_date"], 
                        $row["insert_by"], 
                        $row["update_date"], 
                        $row["update_by"]);
            $result->close();
            return $user;
        } else {
            return null;
//            die($this->db->error);
        }
        
    }
    
    public function addUser($email, $hashedPassword, $name, $icNumber,
                $phone, $dob, $address, $type, $filePath){
        // nho check $user->getType()
        $query = "INSERT INTO user (
              `email`, `password`, `name`, `ic_number`, `phone`, 
              `date_of_birth`, `address`, `type`, `image`, `status`, 
              `insert_date`, `insert_by`, `update_date`, `update_by`
            )
            VALUES (
              ?, ?, ?, ?, ?, ?, ?, "
                . (unserialize($_SESSION["current_user"])->getType() == EMPLOYEE_ROLE ? strval(USER_ROLE) : $type())
                . ", ?, "
                . strval(USER_ACTIVE) .", 
              NOW(), "
                . strval(unserialize($_SESSION["current_user"])->getUserId()) 
                .", NOW(), "
                . strval(unserialize($_SESSION["current_user"])->getUserId())
                . ")";
        echo $query, "\n";
        echo $email, " ", $hashedPassword, " ", $name, " ", $icNumber, " ",
                $phone, " ", $dob, " ", $address, " ", $type, " " , "\n";
        if (!$conn = $this->db->prepare($query)){
            echo $this->db->errno;
            return false;
        }
        $conn->bind_param("ssssssss", $email, $hashedPassword, $name, $icNumber,
                $phone, $dob, $address, $filePath);
        $conn->execute();
        echo $conn->error;
        return $conn->execute();
    }
    
    public function editUser($userId, $email, $hashedPassword, $name, $icNumber,
                $phone, $dob, $address, $type, $filePath){
        $query = "UPDATE user SET "
                . "email = ?,"
                . "password = ?,"
                . "name = ?," 
                . "ic_number = ?,"
                . "phone = ?,"
                . "date_of_birth = ?,"
                . "address = ?,"
                . "type = ". (unserialize($_SESSION["current_user"])->getType() == EMPLOYEE_ROLE ? strval(USER_ROLE) : $type()) . ", "
                . (is_null($filePath) ? "" : "image = '" . $filePath . "', ")
                . "update_date = NOW(), "
                . "update_by = " . strval(unserialize($_SESSION["current_user"])->getUserId())
                . " WHERE user_id = ?"
                . (unserialize($_SESSION["current_user"])->getType() == EMPLOYEE_ROLE ? " AND type = " . strval(USER_ROLE) : "");
        if (!$conn = $this->db->prepare($query)){
            return false;
        }
        $conn->bind_param("sssssssi", $email, $hashedPassword, $name, $icNumber,
                $phone, $dob, $address, $userId);
        return $conn->execute();
    }

    public function deleteUser($userId){
        $query = "UPDATE user SET "
                . "status = " . USER_DELETED . ", "
                . "update_date = NOW(), "
                . "update_by = " . strval(unserialize($_SESSION["current_user"])->getUserId())
                . " WHERE user_id = " . strval($userId)
                . (unserialize($_SESSION["current_user"])->getType() == EMPLOYEE_ROLE ? " AND type = " . strval(USER_ROLE) : "");
        return $this->db->query($query);
    }

}