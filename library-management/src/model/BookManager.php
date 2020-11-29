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
        $query = "SELECT book.* FROM book"
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


    public function findBookById($book_id){
        $query = "SELECT book.* FROM book "
                . "WHERE book.book_id = '%s'";
        $query = sprintf($query, $this->db->real_escape_string($book_id));
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


    public function addPost($title, $content, $userid)
    {
        $query = "INSERT INTO post (
              `title`, `content`, `status`, `id_user`, `date_created`
          )
          VALUES (
              '%s', '%s', 2, '%d', NOW()
          )";
        $query = \sprintf($query, $this->db->real_escape_string($title), $this->db->real_escape_string($content), $this->db->real_escape_string($userid));
        if ($result = $this->db->query($query)) {
            return true;
        } else {
            die($this->db->error);
        }
    }
    
    public function addBook($book){
        $query = "INSERT INTO book (
              `title`, `category`, `author`, `language`, `publisher`, `price`, 
              `amount`, `status`, `insert_date`, `insert_by`, 
              `update_date`, `update_by`
            )
            VALUES (
              '%s', '%s', '%s', '%s', '%s', '%d', '%d', %d, NOW(), %d, NOW(), %d
            )";
        $query = \sprintf($query, 
                $this->db->real_escape_string($book->title), 
                $this->db->real_escape_string($book->category), 
                $this->db->real_escape_string($book->author),
                $this->db->real_escape_string($book->language),
                $this->db->real_escape_string($book->publisher),
                $this->db->real_escape_string($book->price),
                $this->db->real_escape_string($book->amount),
                BOOK_ACTIVE,
                1,
                1);
        if ($result = $this->db->query($query)) {
            return true;
        } else {
            die($this->db->error);
        }
    }
    
    public function editBook($book){
        $query = "UPDATE book SET "
                . (is_null($book->title) ? "" : ("title = " . mysql_real_escape_string($book->title) . ", "))
                . (is_null($book->category) ? "" : ("category = " . mysql_real_escape_string($book->category) . ", "))
                . (is_null($book->author) ? "" : ("author = " . mysql_real_escape_string($book->author) . ", "))
                . (is_null($book->language) ? "" : ("language = " . mysql_real_escape_string($book->language) . ", "))
                . (is_null($book->publisher) ? "" : ("publisher = " . mysql_real_escape_string($book->publisher) . ", "))
                . (is_null($book->price) ? "" : ("price = " . mysql_real_escape_string($book->price) . ", "))
                . (is_null($book->amount) ? "" : ("amount = " . mysql_real_escape_string($book->amount). ", "))
                . "update_date = " . NOW() . ", "
                . "update_by = " . strval(1)
                . " WHERE book_id = " . strval($book->book_id);
        if ($result = $this->db->query($query)) {
            return true;
        } else {
            die($this->db->error);
        }
    }

    public function deleteBook($book_id){
        $query = "UPDATE book SET "
                . "status = " . BOOK_DELETED . ", "
                . "update_date = " . NOW() . ", "
                . "update_by = " . strval(1)
                . " WHERE book_id = " . strval($book_id);
        if ($result = $this->db->query($query)) {
            return true;
        } else {
            die($this->db->error);
        }
    }
}