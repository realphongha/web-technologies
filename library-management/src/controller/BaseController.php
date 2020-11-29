<?php

abstract class BaseController{
    abstract protected function view($request, $queries);
    
    protected function redirect($route="/"){
        header("location: $route");
        exit;
    }
}