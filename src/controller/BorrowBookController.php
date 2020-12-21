<?php

require_once __DIR__ . '/../model/BorrowBookManager.php';
require_once __DIR__ . '/../model/BookManager.php';
require_once __DIR__ . '/../view/BaseView.php';
require_once __DIR__ . '/../model/Pagination.php';
require_once __DIR__ . '/../utils/Constant.php';

class BorrowBookController extends BaseController{
    
    private $dbConnection;

    public function __construct($dbConnection){
        $this->dbConnection = $dbConnection;
        $this->bbookManager = new BorrowBookManager($dbConnection);
        $this->bookManager = new BookManager($dbConnection);
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
            $queries["pageSize"] = DEFAULT_PAGE_SIZE;
        }
        if (!array_key_exists("sortBy", $queries)){
            $queries["sortBy"] = "insert_date";
        }
        if (!array_key_exists("sortOrder", $queries) || 
                (strtolower($queries["sortOrder"]) != "asc" &&
                strtolower($queries["sortOrder"]) != "desc")){
            $queries["sortOrder"] = "asc";
        }
        if (!array_key_exists("status", $queries)|| 
                !is_numeric($queries["status"]) || $queries["status"] < 0||
                $queries["status"] > 4){
            $queries["status"] = null;
        }
        $bbooks = $this->bbookManager->findAllBorrowBooks($queries["page"],
                $queries["pageSize"], $queries["sortBy"], 
                $queries["sortOrder"], 
                array_key_exists("keyword", $request)?$request["keyword"]:null,
                $queries["status"]);
        if (is_null($bbooks)){
            $this->redirect("/error/internal");
            return;
        }
        $count = $this->bbookManager->countBorrowBooks(
                array_key_exists("keyword", $request)?$request["keyword"]:null,
                $queries["status"]);
        if (is_null($count)){
            $this->redirect("/error/internal");
            return;
        }
        $pagination = new Pagination($queries["page"], sizeof($bbooks),
                (int) ($count/$queries["pageSize"]) + ($count%$queries["pageSize"] == 0 ? 0 : 1), 
                $queries["pageSize"], $count, array_key_exists("keyword", $request)?$request["keyword"]:"");
        $View = new BaseView("bbook", "list");
        $message = null;
        if (array_key_exists("message", $queries)){
            if ($queries["message"] == "added"){
                $message = "Thêm mới giao dịch thành công";
            } else if ($queries["message"] == "changed"){
                $message = "Thay đổi giao dịch thành công";
            } else if ($queries["message"] == "error"){
                $message = "Có lỗi xảy ra";
            }
        }
        $View->renderView($message, array($bbooks, $pagination, 
            is_null($queries["status"])?-1:$queries["status"]));
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
        $bbook = $this->bbookManager->findBorrowBookById($queries["id"]);
        if (is_null($bbook)){
            $this->redirect("/error/notFound");
            return;
        }
        $View = new BaseView("bbook", "view");
        $View->renderView(null, $bbook);
    }
    
    public function add($request, $queries){
        if ($this->getRole() != EMPLOYEE_ROLE && $this->getRole() != ADMIN_ROLE){
            $this->redirect("/error/accessDenied");
            return;
        }
        if (!array_key_exists("bookId", $request)){
            $View = new BaseView("bbook", "add");
            $View->renderView();
            return;
        }
        $View = new BaseView("bbook", "add");
        if (!is_numeric($request["bookId"])){
            $View->renderView("ID sách không phải là số");
            return;
        }
        if (!array_key_exists("userId", $request)){
            $View->renderView("Bạn vui lòng nhập ID người mượn");
            return;
        }
        if (!is_numeric($request["userId"])){
            $View->renderView("ID người mượn không phải là số");
            return;
        }
        if (!array_key_exists("quantity", $request)){
            $View->renderView("Bạn vui lòng nhập số lượng sách");
            return;
        }
        if (!is_numeric($request["quantity"])){
            $View->renderView("Số lượng sách không phải là số");
            return;
        }
        if (!array_key_exists("fee", $request)){
            $View->renderView("Bạn vui lòng nhập phí giao dịch");
            return;
        }
        if (!is_numeric($request["fee"])){
            $View->renderView("Phí giao dịch không phải là số");
            return;
        }
        if ($this->bbookManager->addBorrowBook(
                $request["bookId"], 
                $request["userId"], 
                $request["quantity"], 
                $request["fee"])){
            $this->redirect("/bbook/list?message=added");
        } else {
            $this->redirect("/error/internal");
        }
        
    }

    public function rent($request, $queries){
        if (!isset($_SESSION["current_user"]) || !$_SESSION["current_user"]){
            $this->redirect("/book/view?id=" . strval($request["bookId"]) . "&message=plsLogin");
            return;
        }
        if (!array_key_exists("bookId", $request)){
            $this->redirect("/error/accessDenied");
            return;
        }
        if (!is_numeric($request["bookId"])){
            $View->renderView("ID sách không phải là số");
            return;
        }
        $book = $this->bookManager->findBookById($request["bookId"]);
        if (is_null($book)){
            $this->redirect("/error/notFound");
            return;
        }
        if ($this->bbookManager->addBorrowBook(
                $request["bookId"], 
                unserialize($_SESSION["current_user"])->getUserId(), 
                1, $book->getFee())){
            $this->redirect("/book/view?id=" . strval($request["bookId"]) . "&message=rentSuccess");
        } else {
            $this->redirect("/book/view?id=" . strval($request["bookId"]) . "&message=error");
        }
        
    }
    
    public function change($request, $queries){
        if ($this->getRole() != EMPLOYEE_ROLE && $this->getRole() != ADMIN_ROLE){
            $this->redirect("/error/accessDenied");
            return;
        }
        if (!array_key_exists("id", $queries) || !is_numeric($queries["id"])
                || !array_key_exists("status", $queries) 
                || !is_numeric($queries["status"])){
            $this->redirect("/error/notFound");
            return;
        }
        if($this->bbookManager->changeStatusBorrowBook($queries["id"], 
                $queries["status"])){
            $this->redirect("/bbook/list?message=changed");
        } else {
            $this->redirect("/error/internal");
        }
    }
    
}