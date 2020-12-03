<?php

require_once __DIR__ . '/../utils/Constant.php';
require_once __DIR__ . '/./BorrowBook.php';

class BorrowBookManager{

    private $db;

    public function __construct($dbConnection){
        if ($dbConnection instanceof mysqli) {
            $this->db = $dbConnection;
        } else {
            throw new Exception('Connection injected is not a Mysqli object');
        }
    }

    public function findAllBorrowBooks($page, $pageSize, $sortBy, $sortOrder){
        $bbooks = [];
        $query = "SELECT * FROM borrow_book"
                . " ORDER BY " . $sortBy . " " . $sortOrder . " LIMIT " . 
                strval(($page-1)*$pageSize) . ", " . strval($pageSize);
        $result = $this->db->query($query);
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $bbooks[] = new BorrowBook(
                    $row['borrow_book_id'],
                    $row['book_id'],
                    $row['user_id'],
                    $row['time_request'],
                    $row['time_borrow'],
                    $row['quantity'],
                    $row['fee'],
                    $row['status'],
                    $row['insert_date'],
                    $row['insert_by'],
                    $row['update_date'],
                    $row['update_by']);
            }
            $result->close();
        } else {
            echo($this->db->error);
        }
        return $bbooks;
    }


    public function findBorrowBookById($bbookId){
        $query = "SELECT * FROM borrow_book "
                . "WHERE borrow_book.borrow_book_id = '%s'";
        $query = sprintf($query, $this->db->real_escape_string($bbookId));
        if ($result = $this->db->query($query)) {
            $row = $result->fetch_assoc();
            $bbook = new BorrowBook(
                    $row['borrow_book_id'],
                    $row['book_id'],
                    $row['user_id'],
                    $row['time_request'],
                    $row['time_borrow'],
                    $row['quantity'],
                    $row['fee'],
                    $row['status'],
                    $row['insert_date'],
                    $row['insert_by'],
                    $row['update_date'],
                    $row['update_by']);
            $result->close();
        } else {
            die($this->db->error);
        }
        return $bbook;
    }
    
    public function addBorrowBook($bbook){
        $query = "INSERT INTO borrow_book (
              `book_id`, `user_id`, `time_request`, `quantity`, 
              `fee`, `status`, 
              `insert_date`, `insert_by`, `update_date`, `update_by`
            )
            VALUES (
              '%d', '%d', NOW(), '%d', '%d', '%d', NOW(), %d, NOW(), %d
            )";
        $query = \sprintf($query, 
                $this->db->real_escape_string($bbook->getBookId()), 
                $this->db->real_escape_string($book->getUserId()), 
                $this->db->real_escape_string($book->getQuantity()),
                $this->db->real_escape_string($book->getFee()),
                $this->db->real_escape_string($book->getStatus),
                $this->db->real_escape_string(unserialize($_SESSION["current_user"])->getUserId()),
                $this->db->real_escape_string(unserialize($_SESSION["current_user"])->getUserId())
                );
        if ($result = $this->db->query($query)) {
            return true;
        } else {
            die($this->db->error);
        }
    }
    
    public function changeStatusBorrowBook($bbookId, $status){
        $query = "UPDATE borrow_book SET ";
        switch ($status){
            case 0:
            case 1:
            case 3:
            case 4:
                $query .= (" status = " . strval($status));
                break;
            case 2:
                $query .= (" status = 2, time_borrow = NOW()");
                break;
            default:
                break;
        }
        $query .= ", update_date = NOW(), "
               . "update_by = " . unserialize($_SESSION["current_user"])->getUserId()
               . " WHERE borrow_book_id = " . strval($bbookId);
        if ($result = $this->db->query($query)) {
            return true;
        } else {
            die($this->db->error);
        }
    }
    
}