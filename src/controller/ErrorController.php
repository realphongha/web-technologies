<?php

require_once __DIR__ . '/../view/BaseView.php';

class ErrorController{
    

    public function __construct($dbConnection){
    }

    public function accessDenied($request, $queries){
        $View = new BaseView("error", "accessDenied");
        $View->renderView();
    }
    
    public function notFound($request, $queries){
        $View = new BaseView("error", "notFound");
        $View->renderView();
    }
    
    public function internal($request, $queries){
        $View = new BaseView("error", "internal");
        $View->renderView();
    }
    
    public function service($request, $queries){
        $View = new BaseView("error", "service");
        $View->renderView();
    }
    
}