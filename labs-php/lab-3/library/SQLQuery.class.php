<?php

class SQLQuery {
    protected $_dbHandle;
    protected $_result;

    /** Connects to database **/

    function connect($address, $account, $pwd, $name) {
        //$this->_dbHandle = mysqli_connect('localhost', 'username', '123456', $name);
        $this->_dbHandle = mysqli_connect($address, $account, $pwd);
        if ($this->_dbHandle) {
            if (mysqli_select_db($this->_dbHandle, $name)) {
                return 1;
            }
            else {
                return 0;
            }
        }
        else {
            return 0;
        }
    }

    /** Disconnects from database **/

    function disconnect() {
        if (mysqli_close($this->_dbHandle) != 0) {
            return 1;
        }  else {
            return 0;
        }
    }
    
    function selectAll() {
    	$query = 'select * from `'.$this->_table.'`';
    	return $this->query($query);
    }
    
    function select($id) {
    	$query = 'select * from `'.$this->_table.'` where `id` = \''.mysqli_real_escape_string($this->_dbHandle, $id).'\'';
    	return $this->query($query, 1);    
    }

    function delete($id) {
        $query = 'delete from items where id = \''.mysqli_real_escape_string($this->_dbHandle, $id).'\'';
        return $this->query($query, 2);
    }
    
    function add($value){
        $query = 'insert into items (item_name) values (\''.$value.'\')';
        return $this->query($query, 2);
    }
	
    /** Custom SQL Query **/

    function query1($query, $mode = 0) {

        $this->_result = mysqli_query($this->_dbHandle,$query);

//        if (preg_match("/select/i",$query)) {
//        $result = array();
//        $table = array();
//        $field = array();
//        $tempResults = array();
//        $numOfFields = mysqli_num_fields($this->_result);
//        for ($i = 0; $i < $numOfFields; ++$i) {
//            array_push($table, $this->_result->fetch_field_direct($i)->def);
//            array_push($field, $this->_result->fetch_field_direct($i)->def);
////            array_push($table,mysqli_fetch_field_direct($this->_result, $i));
////            array_push($field,mysqli_fetch_field_direct($this->_result, $i));
//        }
//
//
//                while ($row = mysqli_fetch_row($this->_result)) {
//                        for ($i = 0; $i < $numOfFields; ++$i) {
//                                $table[$i] = trim(ucfirst($table[$i]),"s");
//                                $tempResults[$table[$i]][$field[$i]] = $row[$i];
//                        }
//                        if ($singleResult == 1) {
//                                mysqli_free_result($this->_result);
//                                return $tempResults;
//                        }
//                        array_push($result,$tempResults);
//                }
//                mysqli_free_result($this->_result);
//                return($result);
            
        if ($mode == 0){    
            return $this->_result->fetch_all();
        } else if ($mode == 1) {
            return $this->_result->fetch_all()[0];
        } else if ($mode == 2) {
            ;
        }
    }
    
    function query($query, $mode = 0) {
        // $mode = 0 -> select many, 1 -> select one, 2 -> insert, delete
        $this->_result = mysqli_query($this->_dbHandle, $query);

        if ($mode <= 1) {
            $result = array();
            $numOfRows = mysqli_num_rows($this->_result);
            for ($i = 0; $i < $numOfRows; ++$i) {
                array_push($result, $this->_result->fetch_object());
            }
        }
        
        if ($mode == 0){  
            return $result;
        } else if ($mode == 1) {
            return $result[0];
        } else if ($mode == 2) {
            return $this->_result;
        }
    }

    /** Get number of rows **/
    function getNumRows() {
        return mysql_num_rows($this->_result);
    }

    /** Free resources allocated by a query **/

    function freeResult() {
        mysql_free_result($this->_result);
    }

    /** Get error string **/

    function getError() {
        return mysql_error($this->_dbHandle);
    }
}
