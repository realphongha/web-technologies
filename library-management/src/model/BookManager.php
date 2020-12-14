<?php

require_once __DIR__ . '/../utils/Constant.php';
require_once __DIR__ . '/./Book.php';

class BookManager{

    private $db;

    public function __construct($dbConnection){
        if ($dbConnection instanceof mysqli) {
            $this->db = $dbConnection;
        } else {
            throw new Exception('Connection injected is not a Mysqli object');
        }
    }
    
    public function findTopBooks($top){
        $books = [];
        $query = "SELECT * FROM book ORDER BY RAND() LIMIT " . strval($top);
        if($result = $this->db->query($query)){
            while ($row = $result->fetch_assoc()) {
                $books[] = new Book(
                    $row['book_id'],
                    $row['title'],
                    $row['category'],
                    $row['author'],
                    $row['language'],
                    $row['publisher'],
                    $row['price'],
                    $row['fee'],
                    $row['amount'],
                    $row['image'],
                    $row['status'],
                    $row['insert_date'],
                    $row['insert_by'],
                    $row['update_date'],
                    $row['update_by']);
            }
            $result->close();
            return $books;
        }else{
            return null;
        }
    }

    public function findAllBooks($page, $pageSize, $sortBy, $sortOrder, $keyword){
        $books = [];
        $query = "SELECT * FROM book"
                . " WHERE status = " . strval(BOOK_ACTIVE)
                . (is_null($keyword)?"":" AND (title LIKE CONCAT('%',?,'%') OR "
                        . "author LIKE CONCAT('%',?,'%') OR "
                        . "category LIKE CONCAT('%',?,'%') OR "
                        . "publisher LIKE CONCAT('%',?,'%')) ")
                . " ORDER BY ? {$sortOrder} LIMIT "
                . strval(($page-1)*$pageSize) . ", " . strval($pageSize);
        if (!$conn = $this->db->prepare($query)){
            return false;
        }
        if (is_null($keyword)){
            $conn->bind_param("s", $sortBy);
        } else {
            $conn->bind_param("sssss", $keyword, $keyword, $keyword, $keyword, $sortBy);
        }
        $conn->execute();
        $result = $conn->get_result();
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $books[] = new Book(
                    $row['book_id'],
                    $row['title'],
                    $row['category'],
                    $row['author'],
                    $row['language'],
                    $row['publisher'],
                    $row['price'],
                    $row['fee'],
                    $row['amount'],
                    $row['image'],
                    $row['status'],
                    $row['insert_date'],
                    $row['insert_by'],
                    $row['update_date'],
                    $row['update_by']);
            }
            $result->close();
            return $books;
        } else {
            return null;
        }
    }


    public function findBookById($bookId){
        $query = "SELECT * FROM book "
                . "WHERE book.book_id = ?";
        if (!$conn = $this->db->prepare($query)){
            return false;
        }
        $conn->bind_param("i", $bookId);
        $conn->execute();
        if ($result = $conn->get_result()) {
            $row = $result->fetch_assoc();
            if (is_null($row)){
                return null;
            }
            $book = new Book(
                    $row['book_id'],
                    $row['title'],
                    $row['category'],
                    $row['author'],
                    $row['language'],
                    $row['publisher'],
                    $row['price'],
                    $row['fee'],
                    $row['amount'],
                    $row['image'],
                    $row['status'],
                    $row['insert_date'],
                    $row['insert_by'],
                    $row['update_date'],
                    $row['update_by']);
            $result->close();
            return $book;
        } else {
            return null;
        }
        
    }
    
    public function addBook($title, $category, $author, $language, $publisher, 
            $price, $fee, $amount, $filePath){
        $query = "INSERT INTO book (
              `title`, `category`, `author`, `language`, `publisher`, `price`, 
              `fee`, `amount`, `image`, `status`, `insert_date`, `insert_by`, 
              `update_date`, `update_by`
            )
            VALUES (
              ?, ?, ?, ?, ?, ?, ?, ?, ?, ". strval(BOOK_ACTIVE) .", NOW(), ". 
                strval(unserialize($_SESSION["current_user"])->getUserId()) . 
                ", NOW(), " 
                . strval(unserialize($_SESSION["current_user"])->getUserId()) .
            ")";
        if (!$conn = $this->db->prepare($query)){
            return false;
        }
//        echo $query;
        $conn->bind_param("sssssiiis", $title, $category, $author, $language, 
                $publisher, $price, $fee, $amount, $filePath);
        return $conn->execute();
    }
    
    public function editBook($bookId, $title, $category, $author, $language, 
            $publisher, $price, $fee, $amount, $filePath){
        $query = "UPDATE book SET "
                . "title = ?, "
                . "category = ?, "
                . "author = ?, "
                . "language = ?, "
                . "publisher = ?, "
                . "price = ?, "
                . "fee = ?, "
                . "amount = ?, "
                . (is_null($filePath) ? "" : "image = '" . $filePath . "', ")
                . "update_date = NOW(), "
                . "update_by = " . strval(unserialize($_SESSION["current_user"])->getUserId())
                . " WHERE book_id = ?";
        if(!$conn = $this->db->prepare($query)){
            return false;
        }
        $conn->bind_param("sssssiiii", $title, $category, $author, $language, 
                $publisher, $price, $fee, $amount, $bookId);
        return $conn->execute();
    }

    public function deleteBook($bookId){
        $query = "UPDATE book SET "
                . "status = " . BOOK_DELETED . ", "
                . "update_date = NOW(), "
                . "update_by = " . strval(unserialize($_SESSION["current_user"])->getUserId())
                . " WHERE book_id = " . strval($bookId);
        return $this->db->query($query);
    }
}