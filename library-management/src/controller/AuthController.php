<?php

require_once __DIR__ . '/../model/UserManager.php';
require_once __DIR__ . '/../view/BaseView.php';

class AuthController extends BaseController{

    private $dbConnection;

    public function __construct($dbConnection){
        $this->dbConnection = $dbConnection;
        $this->userManager = new UserManager($dbConnection);
        if (is_null($this->userManager)){
            throw new Exception('Connection injected is not a Mysqli object');
        }
    }
    
    public function login($request, $queries){
        if ($this->isLoggedIn()){
            $this->redirect("/error/accessDenied");
            return;
        }
        if (!array_key_exists("email", $request) && 
                !array_key_exists("password", $request)){
            $View = new BaseView("home", "");
            $View->renderView();
            return;
        }
        $View = new BaseView("auth", "login");
        if (is_null($request["email"])){
            $View->renderView("Bạn vui lòng nhập email");
            return;
        } 
        if (is_null($request["password"])){
            $View->renderView("Bạn vui lòng nhập password");
            return;
        } 
        $email = filter_var($request["email"], FILTER_VALIDATE_EMAIL);
        $password = $request["password"];
        if (!filter_var($password, FILTER_VALIDATE_REGEXP,
            array( "options"=> array( "regexp" => "/.{6,25}/")))){
            return false;
        }
        $user = $this->userManager->findUserByEmailAndPassword($email, 
                encryptPassword($password));
        if ($user) {
            $_SESSION["current_user"] = serialize($user);
            $this->redirect();
        } else {
            $View = new BaseView("home", "");
            $View->renderView("Đăng nhập thất bại!");
        }
    }
    
    public function logout($request, $queries){
        if ($this->isLoggedIn()){
            unset($_SESSION["current_user"]);
            $this->redirect();
        } else {
            $this->redirect("/error/accessDenied");
        }
    }

}