<?php

require_once __DIR__ . '/./BaseModel.php';

class BorrowBook extends BaseModel{
    
    private $borrowBookId;
    private $bookId;
    private $bookName;
    private $userId;
    private $userName;
    private $timeBorrow;
    private $timeRequest;
    private $quantity;
    private $fee;
    private $status;
    
    function __construct($borrowBookId, $bookId, $bookName, $userId, $userName,
            $timeRequest, $timeBorrow, $quantity, $fee, $status, 
            $insertDate, $insertBy, $updateDate, $updateBy) {
        parent::__construct($insertDate, $insertBy, $updateDate, $updateBy);
        $this->borrowBookId = $borrowBookId;
        $this->bookId = $bookId;
        $this->bookName = $bookName;
        $this->userId = $userId;
        $this->userName = $userName;
        $this->timeRequest = $timeRequest;
        $this->timeBorrow = $timeBorrow;
        $this->quantity = $quantity;
        $this->fee = $fee;
        $this->status = $status;
    }

    function getBorrowBookId() {
        return $this->borrowBookId;
    }

    function getBookId() {
        return $this->bookId;
    }

    function getUserId() {
        return $this->userId;
    }

    function getTimeRequest() {
        return $this->timeRequest;
    }

    function getTimeBorrow() {
        return $this->timeBorrow;
    }
    
    function getQuantity() {
        return $this->quantity;
    }

    function getFee() {
        return $this->fee;
    }

    function getStatus() {
        return $this->status;
    }

    function setBorrowBookId($borrowBookId): void {
        $this->borrowBookId = $borrowBookId;
    }

    function setBookId($bookId): void {
        $this->bookId = $bookId;
    }

    function setUserId($userId): void {
        $this->userId = $userId;
    }

    function setTimeRequest($timeRequest): void {
        $this->timeRequest = $timeRequest;
    }
    
    function setTimeBorrow($timeBorrow): void {
        $this->timeBorrow = $timeBorrow;
    }

    function setQuantity($quantity): void {
        $this->quantity = $quantity;
    }

    function setFee($fee): void {
        $this->fee = $fee;
    }

    function setStatus($status): void {
        $this->status = $status;
    }
    
    function getBookName() {
        return $this->bookName;
    }

    function getUserName() {
        return $this->userName;
    }

    function setBookName($bookName): void {
        $this->bookName = $bookName;
    }

    function setUserName($userName): void {
        $this->userName = $userName;
    }

}

