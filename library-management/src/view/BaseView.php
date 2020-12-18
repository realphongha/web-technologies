<?php

class BaseView{

    private $content; // content of page output

    public function __construct($controller, $action){
        $tmp = \debug_backtrace();
        $this->controller = $controller;
        $this->action = $action;
    }


    public function __destruct(){
//        include "../src/view/fragments/template.php";
    }


    public function renderView($message = null, $variables = null){
        \ob_start();
        if ($this->action == ""){
            require "../src/view/{$this->controller}/index.php";
        } else{
            require "../src/view/{$this->controller}/{$this->action}.php";
        }
//        $this->content = \ob_get_clean();
    }


    public function indexView(){
        $this->content = "Library online web sample";
    }


}