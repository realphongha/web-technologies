<?php

class Book{
    
    private $user_id;
    private $email;
    private $password;
    private $name;
    private $ic_number;
    private $phone;
    private $date_of_birth;
    private $address;
    private $type;
    private $status;
    private $insert_date;
    private $insert_by;
    private $update_date;
    private $update_by;
    
    function __construct($user_id, $email, $password, $name, $ic_number, $phone, 
            $date_of_birth, $address, $type, $status, 
            $insert_date, $insert_by, $update_date, $update_by) {
        $this->user_id = $user_id;
        $this->email = $email;
        $this->password = $password;
        $this->name = $name;
        $this->ic_number = $ic_number;
        $this->phone = $phone;
        $this->date_of_birth = $date_of_birth;
        $this->address = $address;
        $this->type = $type;
        $this->status = $status;
        $this->insert_date = $insert_date;
        $this->insert_by = $insert_by;
        $this->update_date = $update_date;
        $this->update_by = $update_by;
    }
    
    function getUser_id() {
        return $this->user_id;
    }

    function getEmail() {
        return $this->email;
    }

    function getPassword() {
        return $this->password;
    }

    function getName() {
        return $this->name;
    }

    function getIc_number() {
        return $this->ic_number;
    }

    function getPhone() {
        return $this->phone;
    }

    function getDate_of_birth() {
        return $this->date_of_birth;
    }

    function getAddress() {
        return $this->address;
    }

    function getType() {
        return $this->type;
    }

    function getStatus() {
        return $this->status;
    }

    function getInsert_date() {
        return $this->insert_date;
    }

    function getInsert_by() {
        return $this->insert_by;
    }

    function getUpdate_date() {
        return $this->update_date;
    }

    function getUpdate_by() {
        return $this->update_by;
    }

    function setUser_id($user_id): void {
        $this->user_id = $user_id;
    }

    function setEmail($email): void {
        $this->email = $email;
    }

    function setPassword($password): void {
        $this->password = $password;
    }

    function setName($name): void {
        $this->name = $name;
    }

    function setIc_number($ic_number): void {
        $this->ic_number = $ic_number;
    }

    function setPhone($phone): void {
        $this->phone = $phone;
    }

    function setDate_of_birth($date_of_birth): void {
        $this->date_of_birth = $date_of_birth;
    }

    function setAddress($address): void {
        $this->address = $address;
    }

    function setType($type): void {
        $this->type = $type;
    }

    function setStatus($status): void {
        $this->status = $status;
    }

    function setInsert_date($insert_date): void {
        $this->insert_date = $insert_date;
    }

    function setInsert_by($insert_by): void {
        $this->insert_by = $insert_by;
    }

    function setUpdate_date($update_date): void {
        $this->update_date = $update_date;
    }

    function setUpdate_by($update_by): void {
        $this->update_by = $update_by;
    }

}

