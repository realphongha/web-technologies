<?php

require_once __DIR__ . '/../model/BookManager.php';
require_once __DIR__ . '/../view/BaseView.php';
require_once __DIR__ . '/../model/Pagination.php';
require_once __DIR__ . '/../utils/Constant.php';

class BookController extends BaseController{
    
    private $dbConnection;

    public function __construct($dbConnection){
        $this->dbConnection = $dbConnection;
        $this->bookManager = new BookManager($dbConnection);
    }

    public function list($request, $queries){
        if (!array_key_exists("page", $queries) || 
                !is_numeric($queries["page"]) || $queries["page"] < 1){
            $queries["page"] = 1;
        }
        if (!array_key_exists("pageSize", $queries)|| 
                !is_numeric($queries["pageSize"]) || $queries["pageSize"] < 1){
            $queries["pageSize"] = DEFAULT_PAGE_SIZE;
        }
        if (!array_key_exists("sortBy", $queries)){
            $queries["sortBy"] = "insert_date";
        }
        if (!array_key_exists("sortOrder", $queries) || 
                (strtolower($queries["sortOrder"]) != "asc" &&
                strtolower($queries["sortOrder"]) != "desc")){
            $queries["sortOrder"] = "desc";
        }
        $books = $this->bookManager->findAllBooks($queries["page"],
                $queries["pageSize"], $queries["sortBy"], 
                $queries["sortOrder"], 
                array_key_exists("keyword", $request)?$request["keyword"]:null);
        if (is_null($books)){
            $this->redirect("/error/internal");
            return;
        }
        $count = $this->bookManager->countBooks(
                array_key_exists("keyword", $request)?$request["keyword"]:null);
        if (is_null($count)){
            $this->redirect("/error/internal");
            return;
        }
        $pagination = new Pagination($queries["page"], sizeof($books),
                (int) ($count/$queries["pageSize"]) + ($count%$queries["pageSize"] == 0 ? 0 : 1), 
                $queries["pageSize"], $count, array_key_exists("keyword", $request)?$request["keyword"]:"");
        $View = new BaseView("book", "list");
        $message = null;
        if (array_key_exists("message", $queries)){
            if ($queries["message"] == "added"){
                $message = "Thêm mới sách thành công";
            } else if ($queries["message"] == "updated"){
                $message = "Cập nhật sách thành công";
            } else if ($queries["message"] == "deleted"){
                $message = "Xóa sách thành công";
            } else if ($queries["message"] == "error"){
                $message = "Có lỗi xảy ra";
            }
        }
        $View->renderView($message, array($books, $pagination));
    }
    
    public function view($request, $queries){
        if (!array_key_exists("id", $queries)){
            $this->redirect("/error/notFound");
            return;
        }
        $book = $this->bookManager->findBookById($queries["id"]);
        if (is_null($book)){
            $this->redirect("/error/notFound");
            return;
        }
        $View = new BaseView("book", "view");
        $message = null;
        if (array_key_exists("message", $queries)){
            if ($queries["message"] == "rentSuccess"){
                $message = "Yêu cầu mượn sách thành công, vui lòng tới thư viện để lấy sách";
            } else if ($queries["message"] == "error"){
                $message = "Có lỗi xảy ra";
            } else if ($queries["message"] == "plsLogin"){
                $message = "Bạn cần đăng nhập trước khi mượn sách";
            }
        }
        $View->renderView($message, $book);
    }
    
    public function add($request, $queries){
        if ($this->getRole() != EMPLOYEE_ROLE && $this->getRole() != ADMIN_ROLE){
            $this->redirect("/error/accessDenied");
            return;
        }
        if (!array_key_exists("title", $request)){
            $View = new BaseView("book", "add");
            $View->renderView();
            return;
        }
        $View = new BaseView("book", "add");
        if (strlen($request["title"]) == 0){
            $View->renderView("Bạn vui lòng nhập tên sách");
            return;
        }
        if (strlen($request["title"]) > 50){
            $View->renderView("Tên sách không quá 50 ký tự");
            return;
        }
        if (!array_key_exists("category", $request) || strlen($request["category"]) == 0){
            $View->renderView("Bạn vui lòng nhập thể loại");
            return;
        }
        if (strlen($request["category"]) > 50){
            $View->renderView("Tên thể loại không quá 50 ký tự");
            return;
        }
        if (!array_key_exists("author", $request) || strlen($request["author"]) == 0){
            $View->renderView("Bạn vui lòng nhập tên tác giả");
            return;
        }
        if (strlen($request["author"]) > 50){
            $View->renderView("Tên tác giả không quá 50 ký tự");
            return;
        }
        if (!array_key_exists("language", $request) || strlen($request["language"]) == 0){
            $View->renderView("Bạn vui lòng nhập ngôn ngữ");
            return;
        }
        if (strlen($request["language"]) > 50){
            $View->renderView("Tên ngôn ngữ không quá 50 ký tự");
            return;
        }
        if (array_key_exists("publisher", $request) && strlen($request["publisher"]) > 50){
            $View->renderView("Tên nhà xuất bản không quá 50 ký tự");
            return;
        }
        if (!array_key_exists("price", $request) || is_null($request["price"])){
            $View->renderView("Bạn vui lòng nhập giá sách");
            return;
        }
        if (!is_numeric($request["price"])){
            $View->renderView("Giá sách không phải là số");
            return;
        }
        if ($request["price"] <= 0){
            $View->renderView("Giá sách phải lớn hơn 0");
            return;
        }
        if (!array_key_exists("fee", $request) || is_null($request["fee"])){
            $View->renderView("Bạn vui lòng nhập giá mượn sách");
            return;
        }
        if (!is_numeric($request["fee"])){
            $View->renderView("Giá mượn sách không phải là số");
            return;
        }
        if ($request["fee"] <= 0){
            $View->renderView("Giá mượn sách phải lớn hơn 0");
            return;
        }
        if (!array_key_exists("amount", $request) || is_null($request["amount"])){
            $View->renderView("Bạn vui lòng nhập số lượng sách");
            return;
        }
        if (!is_numeric($request["amount"])){
            $View->renderView("Số lượng sách không phải là số");
            return;
        }
        if ($request["amount"] <= 0){
            $View->renderView("Số lượng sách phải lớn hơn 0");
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
        if ($this->bookManager->addBook(
                $request["title"], 
                $request["category"], 
                $request["author"], 
                $request["language"], 
                $request["publisher"], 
                $request["price"],
                $request["fee"],
                $request["amount"],
                $dbFilePath)){
            $this->redirect("/book/list?message=added");
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
            $this->redirect("/book/list");
            return;
        }
        if (!array_key_exists("title", $request)){
            $View = new BaseView("book", "update");
            $book = $this->bookManager->findBookById($queries["id"]);
            if (is_null($book)){
                $this->redirect("/book/list?message=error");
                return;
            }
            $View->renderView(null, $book);
            return;
        }
        $View = new BaseView("book", "update");
        $book = $this->bookManager->findBookById($queries["id"]);
        if (is_null($book)){
            $this->redirect("/book/list?message=error");
            return;
        }
        if (strlen($request["title"]) == 0){
            $View->renderView("Bạn vui lòng nhập tên sách", $book);
            return;
        }
        if (strlen($request["title"]) > 50){
            $View->renderView("Tên sách không quá 50 ký tự", $book);
            return;
        }
        if (!array_key_exists("category", $request) || strlen($request["category"]) == 0){
            $View->renderView("Bạn vui lòng nhập thể loại", $book);
            return;
        }
        if (strlen($request["category"]) > 50){
            $View->renderView("Tên thể loại không quá 50 ký tự", $book);
            return;
        }
        if (!array_key_exists("author", $request) || strlen($request["author"]) == 0){
            $View->renderView("Bạn vui lòng nhập tên tác giả", $book);
            return;
        }
        if (strlen($request["author"]) > 50){
            $View->renderView("Tên tác giả không quá 50 ký tự", $book);
            return;
        }
        if (!array_key_exists("language", $request) || strlen($request["language"]) == 0){
            $View->renderView("Bạn vui lòng nhập ngôn ngữ", $book);
            return;
        }
        if (strlen($request["language"]) > 50){
            $View->renderView("Tên ngôn ngữ không quá 50 ký tự", $book);
            return;
        }
        if (array_key_exists("publisher", $request) && strlen($request["publisher"]) > 50){
            $View->renderView("Tên nhà xuất bản không quá 50 ký tự", $book);
            return;
        }
        if (!array_key_exists("price", $request) || is_null($request["price"])){
            $View->renderView("Bạn vui lòng nhập giá sách", $book);
            return;
        }
        if ($request["price"] <= 0){
            $View->renderView("Giá sách phải lớn hơn 0", $book);
            return;
        }
        if (!array_key_exists("fee", $request) || is_null($request["fee"])){
            $View->renderView("Bạn vui lòng nhập giá mượn sách", $book);
            return;
        }
        if ($request["fee"] <= 0){
            $View->renderView("Giá mượn sách phải lớn hơn 0", $book);
            return;
        }
        if (!array_key_exists("amount", $request) || is_null($request["amount"])){
            $View->renderView("Bạn vui lòng nhập số lượng sách", $book);
            return;
        }
        if (!is_numeric($request["amount"])){
            $View->renderView("Số lượng sách không phải là số", $book);
            return;
        }
        if ($request["amount"] <= 0){
            $View->renderView("Số lượng sách phải lớn hơn 0", $book);
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
                $View->renderView("Định dạng ảnh không được hỗ trợ (chỉ hỗ trợ jpg, jpeg, png)", $book);
                return;
            } else if ($_FILES["image"]["size"] > MAX_FILE_SIZE){
                $View->renderView("Ảnh vượt quá kích thước cho phép (2MB)", $book);
                return;
            } else if (file_exists($staticFilePath)) {
                $View->renderView("Upload thất bại. Vui lòng thử lại", $book);
                return;
            }
            if (!move_uploaded_file($_FILES["image"]["tmp_name"], $staticFilePath)) {
                $View->renderView("Upload thất bại. Vui lòng thử lại", $book);
                return;
            }
        } else {
            $dbFilePath = null;
        }
        if($this->bookManager->editBook(
                $queries["id"], 
                $request["title"], 
                $request["category"], 
                $request["author"], 
                $request["language"], 
                $request["publisher"], 
                $request["price"], 
                $request["fee"], 
                $request["amount"],
                $dbFilePath)){
            $this->redirect("/book/list?message=updated");
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
        if($this->bookManager->deleteBook($queries["id"])){
            $this->redirect("/book/list?message=deleted");
        } else {
            $this->redirect("/error/internal");
        }
    }
    
}