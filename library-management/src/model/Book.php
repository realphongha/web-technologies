<?php

require_once __DIR__ . '/./BaseModel.php';

class Book extends BaseModel{
    
    private $bookId;
    private $title;
    private $category;
    private $author;
    private $language;
    private $publisher;
    private $price;
    private $fee;
    private $amount;
    private $status;
    
    function __construct($bookId, $title, $category, $author, $language, 
            $publisher, $price, $fee, $amount, $status, 
            $insertDate, $insertBy, $updateDate, $updateBy) {
        parent::__construct($insertDate, $insertBy, $updateDate, $updateBy);
        $this->bookId = $bookId;
        $this->title = $title;
        $this->category = $category;
        $this->author = $author;
        $this->language = $language;
        $this->publisher = $publisher;
        $this->price = $price;
        $this->fee = $fee;
        $this->amount = $amount;
        $this->status = $status;
    }
    
    function getBookId() {
        return $this->bookId;
    }

    function getTitle() {
        return $this->title;
    }

    function getCategory() {
        return $this->category;
    }

    function getAuthor() {
        return $this->author;
    }

    function getLanguage() {
        return $this->language;
    }

    function getPublisher() {
        return $this->publisher;
    }

    function getPrice() {
        return $this->price;
    }
    
    function getFee() {
        return $this->fee;
    }

    function getAmount() {
        return $this->amount;
    }

    function getStatus() {
        return $this->status;
    }

    function setBookId($bookId): void {
        $this->bookId = $bookId;
    }

    function setTitle($title): void {
        $this->title = $title;
    }

    function setCategory($category): void {
        $this->category = $category;
    }

    function setAuthor($author): void {
        $this->author = $author;
    }

    function setLanguage($language): void {
        $this->language = $language;
    }

    function setPublisher($publisher): void {
        $this->publisher = $publisher;
    }

    function setPrice($price): void {
        $this->price = $price;
    }
    
    function setFee($fee): void {
        $this->fee = $fee;
    }

    function setAmount($amount): void {
        $this->amount = $amount;
    }

    function setStatus($status): void {
        $this->status = $status;
    }

}

