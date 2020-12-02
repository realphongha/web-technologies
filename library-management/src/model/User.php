<?php

require_once __DIR__ . '/./BaseModel.php';

class User extends BaseModel{
    
    private $userId;
    private $email;
    private $password;
    private $name;
    private $icNumber;
    private $phone;
    private $dateOfBirth;
    private $address;
    private $type;
    private $status;
    
    function __construct($userId, $email, $password, $name, $icNumber, $phone, 
            $dateOfBirth, $address, $type, $status,
            $insertDate, $insertBy, $updateDate, $updateBy) {
        parent::__construct($insertDate, $insertBy, $updateDate, $updateBy);
        $this->userId = $userId;
        $this->email = $email;
        $this->password = $password;
        $this->name = $name;
        $this->icNumber = $icNumber;
        $this->phone = $phone;
        $this->dateOfBirth = $dateOfBirth;
        $this->address = $address;
        $this->type = $type;
        $this->status = $status;
    }
    
    function getUserId() {
        return $this->userId;
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

    function getIcNumber() {
        return $this->icNumber;
    }

    function getPhone() {
        return $this->phone;
    }

    function getDateOfBirth() {
        return $this->dateOfBirth;
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

    function setUserId($userId): void {
        $this->userId = $userId;
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

    function setIcNumber($icNumber): void {
        $this->icNumber = $icNumber;
    }

    function setPhone($phone): void {
        $this->phone = $phone;
    }

    function setDateOfBirth($dateOfBirth): void {
        $this->dateOfBirth = $dateOfBirth;
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

}

