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

    public function findAllBooks($page, $pageSize, $sortBy, $sortOrder){
        $books = [];
        $query = "SELECT * FROM book"
                . " WHERE status = " . strval(BOOK_ACTIVE)
                . " ORDER BY " . $sortBy . " " . $sortOrder . " LIMIT " . 
                strval(($page-1)*$pageSize) . ", " . strval($pageSize);
        $result = $this->db->query($query);
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
        return $books;
    }


    public function findBookById($bookId){
        $query = "SELECT * FROM book "
                . "WHERE book.book_id = %d";
        $query = sprintf($query, $this->db->real_escape_string($bookId));
        if ($result = $this->db->query($query)) {
            $row = $result->fetch_assoc();
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
                    $row['status'],
                    $row['insert_date'],
                    $row['insert_by'],
                    $row['update_date'],
                    $row['update_by']);
            $result->close();
        } else {
            die($this->db->error);
        }
        return $book;
    }
    
    public function addBook($book){
        $query = "INSERT INTO book (
              `title`, `category`, `author`, `language`, `publisher`, `price`, 
              `fee`, `amount`, `status`, `insert_date`, `insert_by`, 
              `update_date`, `update_by`
            )
            VALUES (
              '%s', '%s', '%s', '%s', '%s', '%d', '%d', '%d', %d, NOW(), %d, NOW(), %d
            )";
        $query = \sprintf($query, 
                $this->db->real_escape_string($book->getTitle()), 
                $this->db->real_escape_string($book->getCategory()), 
                $this->db->real_escape_string($book->getAuthor()),
                $this->db->real_escape_string($book->getLanguage()),
                $this->db->real_escape_string($book->getPublisher()),
                $this->db->real_escape_string($book->getPrice()),
                $this->db->real_escape_string($book->getFee()),
                $this->db->real_escape_string($book->getAmount()),
                BOOK_ACTIVE,
                unserialize($_SESSION["current_user"])->getUserId(),
                unserialize($_SESSION["current_user"])->getUserId());
        if ($result = $this->db->query($query)) {
            return true;
        } else {
            die($this->db->error);
        }
    }
    
    public function editBook($book){
        $query = "UPDATE book SET "
                . (is_null($book->getTitle()) ? "" : ("title = '" . $this->db->real_escape_string($book->getTitle()) . "', "))
                . (is_null($book->getCategory()) ? "" : ("category = '" . $this->db->real_escape_string($book->getCategory()) . "', "))
                . (is_null($book->getAuthor()) ? "" : ("author = '" . $this->db->real_escape_string($book->getAuthor()) . "', "))
                . (is_null($book->getLanguage()) ? "" : ("language = '" . $this->db->real_escape_string($book->getLanguage()) . "', "))
                . (is_null($book->getPublisher()) ? "" : ("publisher = '" . $this->db->real_escape_string($book->getPublisher()) . "', "))
                . (is_null($book->getPrice()) ? "" : ("price = " . $this->db->real_escape_string($book->getPrice()) . ", "))
                . (is_null($book->getFee()) ? "" : ("fee = " . $this->db->real_escape_string($book->getFee()) . ", "))
                . (is_null($book->getAmount()) ? "" : ("amount = " . $this->db->real_escape_string($book->getAmount()). ", "))
                . "update_date = NOW(), "
                . "update_by = " . strval(unserialize($_SESSION["current_user"])->getUserId())
                . " WHERE book_id = " . strval($book->getBookId());
//        echo $query;
        if ($result = $this->db->query($query)) {
            return true;
        } else {
            die($this->db->error);
        }
    }

    public function deleteBook($bookId){
        $query = "UPDATE book SET "
                . "status = " . BOOK_DELETED . ", "
                . "update_date = NOW(), "
                . "update_by = " . strval(unserialize($_SESSION["current_user"])->getUserId())
                . " WHERE book_id = " . strval($bookId);
        if ($result = $this->db->query($query)) {
            return true;
        } else {
            die($this->db->error);
        }
    }
}