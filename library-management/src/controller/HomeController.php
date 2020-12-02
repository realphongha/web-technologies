<?php

require_once __DIR__ . '/../model/BookManager.php';
require_once __DIR__ . '/../view/BaseView.php';

class HomeController extends BaseController{
    
    private $dbConnection;

    public function __construct($dbConnection){
        $this->dbConnection = $dbConnection;
        $this->bookManager = new BookManager($dbConnection);
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
    
    public function view($request, $queries){
        $View = new BaseView("home", "");
        $View->renderView();
    }
    
    public function add($request, $queries){
        
    }
    
    public function update($request, $queries){
        
    }
    
    public function delete($request, $queries){
        if (!array_key_exists("id", $queries)){
            return;
        }
        $this->bookManager->deleteBook($queries["id"]);
        $View = new BaseView("book", "list");
        $View->renderView($books);
    }
    
}