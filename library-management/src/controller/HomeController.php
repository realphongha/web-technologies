<?php

require_once __DIR__ . '/../model/BookManager.php';
require_once __DIR__ . '/../view/BaseView.php';

class HomeController extends BaseController{
    
    private $dbConnection;

    public function __construct($dbConnection){
        $this->dbConnection = $dbConnection;
        $this->bookManager = new BookManager($dbConnection);
    }
    
    public function view($request, $queries){
        $View = new BaseView("home", "");
        $View->renderView();
    }
    
}