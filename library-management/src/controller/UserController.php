<?php

require_once __DIR__ . '/../model/UserManager.php';
require_once __DIR__ . '/../view/BaseView.php';

class UserController extends BaseController{
    
    private $dbConnection;

    public function __construct($dbConnection){
        $this->dbConnection = $dbConnection;
        $this->userManager = new UserManager($dbConnection);
    }
    
    public function list($request, $queries){
        if ($this->getRole() != EMPLOYEE_ROLE && $this->getRole() != ADMIN_ROLE){
            $this->redirect("/error/accessDenied");
            return;
        }
        if (!array_key_exists("page", $queries) || 
                !is_numeric($queries["page"]) || $queries["page"] < 1){
            $queries["page"] = 1;
        }
        if (!array_key_exists("pageSize", $queries)|| 
                !is_numeric($queries["pageSize"]) || $queries["pageSize"] < 1){
            $queries["pageSize"] = 25;
        }
        if (!array_key_exists("sortBy", $queries)){
            $queries["sortBy"] = "insert_date";
        }
        if (!array_key_exists("sortOrder", $queries) || 
                (strtolower($queries["sortOrder"]) != "asc" &&
                strtolower($queries["sortOrder"]) != "desc")){
            $queries["sortOrder"] = "desc";
        }
        $users = $this->userManager->findAllUsers($queries["page"],
                $queries["pageSize"], $queries["sortBy"], 
                $queries["sortOrder"], 
                array_key_exists("keyword", $queries)?$queries["keyword"]:null);
        if (is_null($users)){
            $this->redirect("/error/internal");
            return;
        }
//        print_r($users);
        $View = new BaseView("user", "list");
        $message = null;
        if (array_key_exists("message", $queries)){
            if ($queries["message"] == "added"){
                $message = "Thêm mới người dùng thành công";
            } else if ($queries["message"] == "updated"){
                $message = "Cập nhật người dùng thành công";
            } else if ($queries["message"] == "deleted"){
                $message = "Xóa người dùng thành công";
            } else if ($queries["message"] == "error"){
                $message = "Có lỗi xảy ra";
            }
        }
        $View->renderView($message, $users);
    }
    
    public function view($request, $queries){
        if ($this->getRole() != EMPLOYEE_ROLE && $this->getRole() != ADMIN_ROLE){
            $this->redirect("/error/accessDenied");
            return;
        }
        if (!array_key_exists("id", $queries) || !is_numeric($queries["id"])){
            $this->redirect("/error/notFound");
            return;
        }
        $user = $this->userManager->findUserById($queries["id"]);
//        print_r($user);
        if (is_null($user)){
//            echo "Khong tim thay user nao";
            $this->redirect("/error/notFound");
            return;
        }
        $View = new BaseView("user", "view");
        $View->renderView(null, $user);
    }
    
    public function add($request, $queries){
        if ($this->getRole() != EMPLOYEE_ROLE && $this->getRole() != ADMIN_ROLE){
            $this->redirect("/error/accessDenied");
            return;
        }
        if (!array_key_exists("email", $request)){
            $View = new BaseView("user", "add");
            $View->renderView();
            return;
        }
        $View = new BaseView("user", "add");
        if (!filter_var($request["email"], FILTER_VALIDATE_EMAIL)){
            $View->renderView("Email không đúng định dạng");
            return;
        }
        if (strlen($request["email"]) == 0){
            $View->renderView("Bạn vui lòng nhập email");
            return;
        }
        if (strlen($request["email"]) > 100){
            $View->renderView("Email không quá 50 ký tự");
            return;
        }
        if ($this->userManager->checkExistingEmailCreate($request["email"])){
            $View->renderView("Email đã tồn tại");
            return;
        }
        if (!array_key_exists("password", $request) || strlen($request["password"]) == 0){
            $View->renderView("Bạn vui lòng nhập mật khẩu");
            return;
        }
        if (strlen($request["password"]) < 8){
            $View->renderView("Mật khẩu không dưới 8 ký tự");
            return;
        }
        if (strlen($request["password"]) > 20){
            $View->renderView("Mật khẩu không quá 20 ký tự");
            return;
        }
        if (!array_key_exists("name", $request) || strlen($request["name"]) == 0){
            $View->renderView("Bạn vui lòng nhập họ tên của tài khoản");
            return;
        }
        if (strlen($request["name"]) > 50){
            $View->renderView("Họ tên không quá 50 ký tự");
            return;
        }
        if (!array_key_exists("icNumber", $request) || strlen($request["icNumber"]) == 0){
            $View->renderView("Bạn vui lòng nhập số CMND/căn cước");
            return;
        }
        if (strlen($request["icNumber"]) > 12){
            $View->renderView("Số CMND/căn cước không quá 12 ký tự");
            return;
        }
        if ($this->userManager->checkExistingIcNumCreate($request["icNumber"])){
            $View->renderView("Số CMND/căn cước đã tồn tại");
            return;
        }
        if (!array_key_exists("phone", $request) || strlen($request["phone"]) == 0){
            $View->renderView("Bạn vui lòng nhập số điện thoại");
            return;
        }
        if (strlen($request["phone"]) > 12){
            $View->renderView("Số điện thoại không quá 12 ký tự");
            return;
        }
        if ($this->userManager->checkExistingPhoneCreate($request["phone"])){
            $View->renderView("Số điện thoại đã tồn tại");
            return;
        }
        if (array_key_exists("dateOfBirth", $request) && strlen($request["dateOfBirth"]) == 0){
            $View->renderView("Bạn vui lòng nhập ngày sinh");
            return;
        }
        if (!array_key_exists("address", $request) || strlen($request["address"]) == 0){
            $View->renderView("Bạn vui lòng nhập địa chỉ");
            return;
        }
        if (strlen($request["address"]) > 100){
            $View->renderView("Địa chỉ không quá 12 ký tự");
            return;
        }
        if (!file_exists($_FILES["image"]["tmp_name"])) {
            $View->renderView("Bạn vui lòng upload ảnh");
            return;
        }
        $removeExtension = explode('.', basename($_FILES["image"]["name"]));
        $fileName = date("m-d-y") . date("h-i-sa") 
                . "-" . strval(unserialize($_SESSION["current_user"])->getUserId())
                . ".$removeExtension[1]";
        $staticFilePath = STATIC_IMG_DIRECTORY_BOOK . $fileName;
        $dbFilePath = IMG_DIRECTORY_BOOK . $fileName;
        $fileType = pathinfo($staticFilePath, PATHINFO_EXTENSION);
        if (!in_array($fileType, ALLOW_IMG_TYPES)){
            $View->renderView("Định dạng ảnh không được hỗ trợ (chỉ hỗ trợ jpg, jpeg, png)");
            return;
        } else if ($_FILES["image"]["size"] > MAX_FILE_SIZE){
            $View->renderView("Ảnh vượt quá kích thước cho phép (2MB)");
            return;
        } else if (file_exists($staticFilePath)) {
            $View->renderView("Upload thất bại. Vui lòng thử lại");
            return;
        }
        if (!move_uploaded_file($_FILES["image"]["tmp_name"], $staticFilePath)) {
            $View->renderView("Upload thất bại. Vui lòng thử lại");
            return;
        }
        if ($this->userManager->addUser(
                $request["email"], 
                encryptPassword($request["password"]), 
                $request["name"], 
                $request["icNumber"], 
                $request["phone"], 
                $request["dateOfBirth"],
                $request["address"],
                $request["type"],
                $dbFilePath)){
            $this->redirect("/user/list?message=added");
        } else {
            $this->redirect("/error/internal");
        }
        
    }
    
    public function update($request, $queries){
        if ($this->getRole() != EMPLOYEE_ROLE && $this->getRole() != ADMIN_ROLE){
            $this->redirect("/error/accessDenied");
            return;
        }
        if (!array_key_exists("id", $queries)){
            $this->redirect("/user/list");
            return;
        }
        if (!array_key_exists("email", $request)){
            $View = new BaseView("user", "update");
            $user = $this->userManager->findUserById($queries["id"]);
            if (is_null($user)){
                $this->redirect("/book/list?message=error");
                return;
            }
            $View->renderView(null, $user);
            return;
        }
        $View = new BaseView("user", "update");
        $user = $this->userManager->findUserById($queries["id"]);
        if (is_null($user)){
            $this->redirect("/user/list?message=error");
            return;
        }
        $email = filter_var($request["email"], FILTER_VALIDATE_EMAIL);
        if (strlen($request["email"]) == 0){
            $View->renderView("Bạn vui lòng nhập email", $user);
            return;
        }
        if (strlen($request["email"]) > 100){
            $View->renderView("Email không quá 50 ký tự", $user);
            return;
        }
        if ($this->userManager->checkExistingEmailUpdate($request["email"], $queries["id"])){
            $View->renderView("Email đã tồn tại", $user);
            return;
        }
        if (!array_key_exists("password", $request) || strlen($request["password"]) == 0){
            $View->renderView("Bạn vui lòng nhập mật khẩu", $user);
            return;
        }
        if (strlen($request["password"]) < 8){
            $View->renderView("Mật khẩu không dưới 8 ký tự", $user);
            return;
        }
        if (strlen($request["password"]) > 20){
            $View->renderView("Mật khẩu không quá 20 ký tự", $user);
            return;
        }
        if (!array_key_exists("name", $request) || strlen($request["name"]) == 0){
            $View->renderView("Bạn vui lòng nhập họ tên của tài khoản", $user);
            return;
        }
        if (strlen($request["name"]) > 50){
            $View->renderView("Họ tên không quá 50 ký tự", $user);
            return;
        }
        if (!array_key_exists("icNumber", $request) || strlen($request["icNumber"]) == 0){
            $View->renderView("Bạn vui lòng nhập số CMND/căn cước", $user);
            return;
        }
        if (strlen($request["icNumber"]) > 12){
            $View->renderView("Số CMND/căn cước không quá 12 ký tự", $user);
            return;
        }
        if ($this->userManager->checkExistingIcNumUpdate($request["icNumber"], $queries["id"])){
            $View->renderView("Số CMND/căn cước đã tồn tại");
            return;
        }
        if (!array_key_exists("phone", $request) || strlen($request["phone"]) == 0){
            $View->renderView("Bạn vui lòng nhập số điện thoại", $user);
            return;
        }
        if (strlen($request["phone"]) > 12){
            $View->renderView("Số điện thoại không quá 12 ký tự", $user);
            return;
        }
        if ($this->userManager->checkExistingPhoneUpdate($request["phone"], $queries["id"])){
            $View->renderView("Số điện thoại đã tồn tại", $user);
            return;
        }
        if (array_key_exists("dateOfBirth", $request) && strlen($request["dateOfBirth"]) == 0){
            $View->renderView("Bạn vui lòng nhập ngày sinh", $user);
            return;
        }
        if (!array_key_exists("address", $request) || strlen($request["address"]) == 0){
            $View->renderView("Bạn vui lòng nhập địa chỉ", $user);
            return;
        }
        if (strlen($request["address"]) > 100){
            $View->renderView("Địa chỉ không quá 12 ký tự", $user);
            return;
        }
        if (file_exists($_FILES["image"]["tmp_name"])) {
            $removeExtension = explode('.', basename($_FILES["image"]["name"]));
            $fileName = date("m-d-y") . date("h-i-sa") 
                    . "-" . strval(unserialize($_SESSION["current_user"])->getUserId())
                    . ".$removeExtension[1]";
            $staticFilePath = STATIC_IMG_DIRECTORY_BOOK . $fileName;
            $dbFilePath = IMG_DIRECTORY_BOOK . $fileName;
            $fileType = pathinfo($staticFilePath, PATHINFO_EXTENSION);
            if (!in_array($fileType, ALLOW_IMG_TYPES)){
                $View->renderView("Định dạng ảnh không được hỗ trợ (chỉ hỗ trợ jpg, jpeg, png)");
                return;
            } else if ($_FILES["image"]["size"] > MAX_FILE_SIZE){
                $View->renderView("Ảnh vượt quá kích thước cho phép (2MB)");
                return;
            } else if (file_exists($staticFilePath)) {
                $View->renderView("Upload thất bại. Vui lòng thử lại");
                return;
            }
            if (!move_uploaded_file($_FILES["image"]["tmp_name"], $staticFilePath)) {
                $View->renderView("Upload thất bại. Vui lòng thử lại");
                return;
            }
        } else {
            $dbFilePath = null;
        }
        if($this->userManager->editUser(
                $queries["id"], 
                $request["email"], 
                encryptPassword($request["password"]), 
                $request["name"], 
                $request["icNumber"], 
                $request["phone"], 
                $request["dateOfBirth"],
                $request["address"],
                $request["type"],
                $dbFilePath)){
            $this->redirect("/user/list?message=updated");
        } else {
            $this->redirect("/error/internal");
        }
    }
    
    public function delete($request, $queries){
        if ($this->getRole() != EMPLOYEE_ROLE && $this->getRole() != ADMIN_ROLE){
            $this->redirect("/error/accessDenied");
            return;
        }
        if (!array_key_exists("id", $queries) || !is_numeric($queries["id"])){
            $this->redirect("/error/notFound");
            return;
        }
        if($this->userManager->deleteUser($queries["id"])){
            $this->redirect("/user/list?message=deleted");
        } else {
            $this->redirect("/error/internal");
        }
    }
    
}