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

    public function findAllBorrowBooks($page, $pageSize, $sortBy, $sortOrder,
            $keyword){
        $bbooks = [];
        $query = "SELECT * FROM borrow_book, book, user"
                . " WHERE borrow_book.book_id = book.book_id"
                . " AND borrow_book.user_id = user.user_id"
                . (is_null($keyword)?"":" WHERE (book.title LIKE CONCAT('%',?,'%')"
                . " OR user.name LIKE CONCAT('%',?,'%'))")
                . " ORDER BY ? " . $sortOrder . " LIMIT " . 
                strval(($page-1)*$pageSize) . ", " . strval($pageSize);
        if (!$conn = $this->db->prepare($query)){
            return false;
        }
        if (is_null($keyword)){
            $conn->bind_param("s", $sortBy);
        } else {
            $conn->bind_param("sss", $keyword, $keyword, $sortBy);
        }
        $conn->execute();
        if ($result = $conn->get_result()) {
            while ($row = $result->fetch_assoc()) {
                $bbooks[] = new BorrowBook(
                    $row['borrow_book_id'],
                    $row['book_id'],
                    $row['title'],
                    $row['user_id'],
                    $row['name'],
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
            return $bbooks;
        } else {
            return null;
//            echo($this->db->error);
        }
        
    }


    public function findBorrowBookById($bbookId){
        $query = "SELECT * FROM borrow_book, book, user"
                . " WHERE borrow_book.book_id = book.book_id"
                . " AND borrow_book.user_id = user.user_id"
                . " AND borrow_book.borrow_book_id = " . strval($bbookId);
//        echo $query;
        if ($result = $this->db->query($query)) {
            $row = $result->fetch_assoc();
            if (is_null($row)){
                return null;
            }
            $bbook = new BorrowBook(
                    $row['borrow_book_id'],
                    $row['book_id'],
                    $row['title'],
                    $row['user_id'],
                    $row['name'],
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
            return $bbook;
        } else {
            return null;
//            die($this->db->error);
        }
        
    }
    
    public function addBorrowBook($bookId, $userId, $quantity, $fee){
        $query = "INSERT INTO borrow_book (
              `book_id`, `user_id`, `time_request`, `time_borrow`, `quantity`, 
              `fee`, `status`, 
              `insert_date`, `insert_by`, `update_date`, `update_by`
            )
            VALUES (
              ?, ?, NOW(), NULL, ?, ?, " . strval(BBOOK_PENDING) 
                . ", NOW(), " 
                . strval(unserialize($_SESSION["current_user"])->getUserId())
                . ", NOW(), "
                . strval(unserialize($_SESSION["current_user"])->getUserId())
                . ")";
        if (!$conn = $this->db->prepare($query)){
            return false;
        }
        $conn->bind_param("ssss", $bookId, $userId, $quantity, $fee);
        return $conn->execute();
    }
    
    public function changeStatusBorrowBook($bbookId, $status){
        $query = "UPDATE borrow_book SET ";
        switch ($status){
            case BBOOK_CANCELED:
            case BBOOK_PENDING:
            case BBOOK_RETURNED:
            case BBOOK_LOST:
                $query .= (" status = " . strval($status));
                break;
            case BBOOK_BORROWED:
                $query .= (" status = " . strval(BBOOK_BORROWED) 
                    . ", time_borrow = NOW()");
                break;
            default:
                return false;
        }
        $query .= ", update_date = NOW(), "
               . "update_by = " . strval(unserialize($_SESSION["current_user"])->getUserId())
               . " WHERE borrow_book_id = " . strval($bbookId);
        return $this->db->query($query);
    }
    
}