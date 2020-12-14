<?php

require_once __DIR__ . '/../model/BookManager.php';
require_once __DIR__ . '/../view/BaseView.php';
require_once __DIR__ . '/../utils/Constant.php';

class HomeController extends BaseController{
    
    private $dbConnection;

    public function __construct($dbConnection){
        $this->dbConnection = $dbConnection;
        $this->bookManager = new BookManager($dbConnection);
    }
    
    public function view($request, $queries){
        $books = $this->bookManager->findTopBooks(TOP_BOOK_HOME);
        if (is_null($books)){
            $this->redirect("/error/internal");
            return;
        }
        $View = new BaseView("home", "");
        $View->renderView(null, $books);
    }
    
}