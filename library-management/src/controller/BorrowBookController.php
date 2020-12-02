<?php

require_once __DIR__ . '/../model/BorrowBookManager.php';
require_once __DIR__ . '/../view/BaseView.php';

class BorrowBookController extends BaseController{
    
    private $dbConnection;

    public function __construct($dbConnection){
        $this->dbConnection = $dbConnection;
        $this->bookManager = new BookManager($dbConnection);
    }
    
}