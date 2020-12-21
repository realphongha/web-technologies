<?php

require_once __DIR__ . '/./BaseModel.php';

class Pagination {
    
    private $currentPage;
    private $currentPageSize;
    private $totalPages;
    private $pageSize;
    private $totalRecords;
    private $keyword;
    
    function __construct($currentPage, $currentPageSize, 
            $totalPages, $pageSize, $totalRecords, $keyword) {
        $this->currentPage = $currentPage;
        $this->currentPageSize = $currentPageSize;
        $this->totalPages = $totalPages;
        $this->pageSize = $pageSize;
        $this->totalRecords = $totalRecords;
        $this->keyword = $keyword;
    }

    function getCurrentPage() {
        return $this->currentPage;
    }

    function getTotalPages() {
        return $this->totalPages;
    }

    function getPageSize() {
        return $this->pageSize;
    }

    function getTotalRecords() {
        return $this->totalRecords;
    }

    function setCurrentPage($currentPage): void {
        $this->currentPage = $currentPage;
    }

    function setTotalPages($totalPages): void {
        $this->totalPages = $totalPages;
    }

    function setPageSize($pageSize): void {
        $this->pageSize = $pageSize;
    }

    function setTotalRecords($totalRecords): void {
        $this->totalRecords = $totalRecords;
    }
    
    function getCurrentPageSize() {
        return $this->currentPageSize;
    }

    function setCurrentPageSize($currentPageSize): void {
        $this->currentPageSize = $currentPageSize;
    }
    
    function getKeyword() {
        return $this->keyword;
    }

    function setKeyword($keyword): void {
        $this->keyword = $keyword;
    }
    
}

