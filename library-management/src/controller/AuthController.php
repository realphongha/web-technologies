<?php

require_once __DIR__ . '/../model/UserManager.php';
require_once __DIR__ . '/../view/BaseView.php';

class AuthController extends BaseController{

    private $dbConnection;

    public function __construct($dbConnection){
        $this->dbConnection = $dbConnection;
        $this->userManager = new UserManager($dbConnection);
    }

    public function view($request, $queries) {
        
    }

//    public function loginAction()
//    {
//        if ($this->userManager->isLoggedIn()) {
//            $this->redirectAction();
//        }
//
//        $View = new BlogView($this->blogManager);
//        $View->renderView();
//    }
//
//    public function loginsubmittedAction($request)
//    {
//        $res = $this->userManager->login($request['email'], $request['password']);
//        if ($res) {
//            $this->redirectAction();
//        } else {
//            $this->redirectAction("/login?error=error");
//        }
//    }
//
//    public function logoutAction()
//    {
//        $this->userManager->logout();
//        $this->redirectAction();
//    }

}