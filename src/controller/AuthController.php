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
            array( "options"=> array( "regexp" => "/.{8,20}/")))){
            $View->renderView("Password phải có từ 8 đến 20 ký tự");
            return;
        }
        $user = $this->userManager->findUserByEmailAndPassword($email, 
                encryptPassword($password));
        if (is_null($user)) {
            $View = new BaseView("home", "");
            $View->renderView("Đăng nhập thất bại!");
        } else {
            $_SESSION["current_user"] = serialize($user);
            $this->redirect();
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
    
    public function changePassword($request, $queries){
        if (!$this->isLoggedIn()){
            $this->redirect("/error/accessDenied");
            return;
        }
        if (!array_key_exists("oldPassword", $request) && 
                !array_key_exists("newPassword", $request) &&
                !array_key_exists("confirmPassword", $request)){
            $View = new BaseView("password", "change");
            $View->renderView();
            return;
        }
        $View = new BaseView("password", "change");
        if (is_null($request["oldPassword"])){
            $View->renderView("Bạn vui lòng nhập mật khẩu cũ");
            return;
        } 
        if (is_null($request["newPassword"])){
            $View->renderView("Bạn vui lòng nhập mật khẩu mới");
            return;
        }
        if (is_null($request["confirmPassword"])){
            $View->renderView("Bạn vui lòng nhập mật khẩu xác nhận");
            return;
        } 
        $oldPassword = $request["oldPassword"];
        $newPassword = $request["newPassword"];
        
        if (!filter_var($oldPassword, FILTER_VALIDATE_REGEXP,
            array( "options"=> array( "regexp" => "/.{8,20}/")))){
            $View->renderView("Password phải có từ 8 đến 20 ký tự");
            return;
        }
        if (!filter_var($newPassword, FILTER_VALIDATE_REGEXP,
            array( "options"=> array( "regexp" => "/.{8,20}/")))){
            $View->renderView("Password phải có từ 8 đến 20 ký tự");
            return;
        }
        if ($newPassword != $request["confirmPassword"]){
            $View->renderView("Mật khẩu mới và mật khẩu xác nhận khác nhau");
            return;
        }
        $email = unserialize($_SESSION["current_user"])->getEmail();
        $user = $this->userManager->findUserByEmailAndPassword($email, 
                encryptPassword($oldPassword));
        if (is_null($user)) {
            $View->renderView("Mật khẩu cũ không đúng!");
            return;
        } 
        if ($this->userManager->changePassword($email, 
                encryptPassword($newPassword))){
            $View->renderView("Đổi mật khẩu thành công!");
        } else {
            $View->renderView("Đổi mật khẩu thất bại!");
        }
    }

}