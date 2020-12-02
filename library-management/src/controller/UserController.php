<?php

require_once __DIR__ . '/../model/UserManager.php';
require_once __DIR__ . '/../view/BaseView.php';

class UserController extends BaseController{
    
    private $dbConnection;

    public function __construct($dbConnection){
        $this->dbConnection = $dbConnection;
        $this->bookManager = new BookManager($dbConnection);
    }
    
}