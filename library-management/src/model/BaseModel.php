<?php

class BaseModel{
    
    private $insertDate;
    private $insertBy;
    private $updateDate;
    private $updateBy;
    
    function __construct($insertDate, $insertBy, $updateDate, $updateBy) {
        $this->insertDate = $insertDate;
        $this->insertBy = $insertBy;
        $this->updateDate = $updateDate;
        $this->updateBy = $updateBy;
    }

    function getInsertDate() {
        return $this->insertDate;
    }

    function getInsertBy() {
        return $this->insertBy;
    }

    function getUpdateDate() {
        return $this->updateDate;
    }

    function getUpdateBy() {
        return $this->updateBy;
    }

    function setInsertDate($insertDate): void {
        $this->insertDate = $insertDate;
    }

    function setInsertBy($insertBy): void {
        $this->insertBy = $insertBy;
    }

    function setUpdateDate($updateDate): void {
        $this->updateDate = $updateDate;
    }

    function setUpdateBy($updateBy): void {
        $this->updateBy = $updateBy;
    }

}

