<?php

require_once __DIR__ . '/../model/BookManager.php';
require_once __DIR__ . '/../view/BaseView.php';

class BookController extends BaseController{
    
    private $dbConnection;

    public function __construct($dbConnection){
        $this->dbConnection = $dbConnection;
        $this->bookManager = new BookManager($dbConnection);
    }
    
    public function view($request, $queries) {
        
    }

    public function getList($request, $queries){
        if (!array_key_exists("page", $queries)){
            $queries["page"] = 1;
        }
        if (!array_key_exists("pageSize", $queries)){
            $queries["pageSize"] = 25;
        }
        if (!array_key_exists("sortBy", $queries)){
            $queries["sortBy"] = "insert_date";
        }
        if (!array_key_exists("sortOrder", $queries)){
            $queries["sortOrder"] = "DESC";
        }
        $books = $this->bookManager->findAllBooks($queries["page"],
                $queries["pageSize"], $queries["sortBy"], 
                $queries["sortOrder"]);
        $View = new BaseView("book", "list");
        $View->renderView($books);
    }
    
}