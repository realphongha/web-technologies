<?php

class Book{
    
    private $book_id;
    private $title;
    private $category;
    private $author;
    private $language;
    private $publisher;
    private $price;
    private $amount;
    private $status;
    private $insert_date;
    private $insert_by;
    private $update_date;
    private $update_by;
    
    function __construct($book_id, $title, $category, $author, $language, 
            $publisher, $price, $amount, $status, 
            $insert_date, $insert_by, $update_date, $update_by) {
        $this->book_id = $book_id;
        $this->title = $title;
        $this->category = $category;
        $this->author = $author;
        $this->language = $language;
        $this->publisher = $publisher;
        $this->price = $price;
        $this->amount = $amount;
        $this->status = $status;
        $this->insert_date = $insert_date;
        $this->insert_by = $insert_by;
        $this->update_date = $update_date;
        $this->update_by = $update_by;
    }
    
    function getBook_id() {
        return $this->book_id;
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

    function getAmount() {
        return $this->amount;
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

    function setBook_id($book_id): void {
        $this->book_id = $book_id;
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

    function setAmount($amount): void {
        $this->amount = $amount;
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

