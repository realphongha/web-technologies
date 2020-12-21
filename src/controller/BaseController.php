<?php

require_once __DIR__ . '/../utils/Constant.php';

abstract class BaseController{
    
    protected function redirect($route="/"){
        header("location: $route");
        exit;
    }

    protected function isLoggedIn(){
        return isset($_SESSION["current_user"]) && $_SESSION["current_user"];
    }
    
    protected function getRole(){
        if (isset($_SESSION["current_user"]) && $_SESSION["current_user"]){
            return unserialize($_SESSION["current_user"])->getType();
        }
        return GUEST_ROLE;
    }
}