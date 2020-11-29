<?php

class BaseView{

    private $content; // content of page output

    public function __construct($controller, $action){
        $tmp = \debug_backtrace();
        $this->controller = $controller;
        $this->action = $action;
    }


    public function __destruct(){
    }


    public function renderView($variables = null){
        \ob_start();
        require "../src/view/{$this->controller}/{$this->action}.php";
//        $this->content = \ob_get_clean();
    }


    public function indexView(){
        $this->content = "Library online web sample";
    }


}