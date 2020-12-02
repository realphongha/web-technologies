<?php

require_once __DIR__ . '/../model/BookManager.php';
require_once __DIR__ . '/../view/BaseView.php';
require_once __DIR__ . '/../utils/Constant.php';

class BookController extends BaseController{
    
    private $dbConnection;

    public function __construct($dbConnection){
        $this->dbConnection = $dbConnection;
        $this->bookManager = new BookManager($dbConnection);
    }

    public function list($request, $queries){
        if (!array_key_exists("page", $queries)){
            $queries["page"] = 1;
        }
        if (!array_key_exists("pageSize", $queries)){
            $queries["pageSize"] = 25;
        }
        if (!array_key_exists("sortBy", $queries)){
            $queries["sortBy"] = "insert_date";
        }
        if (!array_key_exists("sortOrder", $queries)){
            $queries["sortOrder"] = "DESC";
        }
        $books = $this->bookManager->findAllBooks($queries["page"],
                $queries["pageSize"], $queries["sortBy"], 
                $queries["sortOrder"]);
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
        $View->renderView($message, $books);
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
        $View->renderView(null, $book);
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
        $book = new Book(null, 
                $request["title"], 
                $request["category"], 
                $request["author"], 
                $request["language"], 
                $request["publisher"], 
                $request["price"], 
                $request["amount"], 
                null, null, null, null, null);
        $this->bookManager->addBook($book);
        $this->redirect("/book/list?message=added");
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
        $book = new Book($queries["id"], 
                $request["title"], 
                $request["category"], 
                $request["author"], 
                $request["language"], 
                $request["publisher"], 
                $request["price"], 
                $request["amount"], 
                null, null, null, null, null);
        $this->bookManager->editBook($book);
        $this->redirect("/book/list?message=updated");
    }
    
    public function delete($request, $queries){
        if ($this->getRole() != EMPLOYEE_ROLE && $this->getRole() != ADMIN_ROLE){
            $this->redirect("/error/accessDenied");
            return;
        }
        if (array_key_exists("id", $queries)){
            $this->bookManager->deleteBook($queries["id"]);
        }
        $this->redirect("/book/list?message=deleted");
    }
    
}