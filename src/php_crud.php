<?php
/**
* PHP CRUD (Create Read Update Delete)
*
* PHP version 5.0
*
* @author     Isi Roca
* @category   PHP & Databases
* @copyright  Copyright (C) 2015 Isi Roca
* @link       http://isiroca.com
* @since      File available since Release 1.0.0
* @license    https://opensource.org/licenses/MIT  The MIT License (MIT)
* @see        https://github.com/IsiRoca/PHP-CRUD/issues
*
*/

class Database{

    /*
	 * Private DB variables
	 */
	private $db_host;
	private $db_user;
	private $db_pass;
	private $db_name;

	/*
	 * Extra variables
	 */
	private $connection = false; // Connection status
    private $conn = ""; // DB Connection
	private $response = array(); // Results from Queries
    private $getQuery = ""; // SQL return
    private $numRows = ""; // Return rows number

    /*
     * Construct
     */
    public function __construct(){
        require_once __DIR__.'/config.php';

        $this->db_host = DB_HOST;
        $this->db_user = DB_USER;
        $this->db_pass = DB_PASS;
        $this->db_name = DB_NAME;
        $this->db_charset = DB_CHARSET;
    }

    /*
     * Database Connect
     */
	public function connect(){
        if(!$this->connection){
            $this->conn = new mysqli($this->db_host,$this->db_user,$this->db_pass,$this->db_name);
            if($this->conn->connect_errno > 0){
                $this->error();
            }else{
                $this->connection = true;
                $this->conn->set_charset($this->db_charset);
                return true;
            }
        }else{
            return true;
        }
	}

    /*
     * Database Disconnect
     */
    public function disconnect(){
        if($this->connection){
            if($this->conn->close()){
                $this->connection = false;
                return true;
            }else{
                return false;
            }
        }
    }

    /*
     * Database Create Database
     */
    public function createDb($database){
        $sql = 'CREATE DATABASE `'.$database.'`';

        if(mysqli_query($this->conn, $sql)){
            return true;
        } else{
            $this->error();
        }
    }

    /*
     * Database Create Table
     */
    public function create($table){
        $response = $this->conn->query('CREATE TABLE IF NOT EXISTS `'.$table.'` (id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY)');

        if ($response) {
            return true;
        } else {
            $this->error();
        }
    }

    /*
     * Database Show all Tables
     */
    public function tables(){
        $response = $this->conn->query('SHOW TABLES FROM '.$this->db_name);

        while($table = @mysqli_fetch_array($response)) {
            array_push($this->response,$table[0]);
        }
        return true;
    }

    /*
     * Database Import External SQL File
     */
    public function import($sqlFile){
        mysqli_multi_query($this->conn,$sqlFile);
        array_push($this->response,$this->conn->error);

        return true;
    }

    /*
     * Database Truncate Table
     */
    public function truncate($table){
        $response = @mysqli_query('TRUNCATE TABLE '.$table);

        return true;
    }

    /*
     * Database Drop Table
     */
    public function drop($table){
        $response = $this->conn->query('DROP TABLE '.$table);

        return true;
    }

    /*
     * Database Check if table exists
     */
    private function tableExists($table){
        $tablesInDb = $this->conn->query('SHOW TABLES FROM '.$this->db_name.' LIKE "'.$table.'"');
        if($tablesInDb){
            if($tablesInDb->num_rows == 1){
                return true;
            }else{
                array_push($this->response,$table." does not exist in this database");
                return false;
            }
        }
    }

    /*
     * Database SQL
     */
	public function sql($sql){
        $query = $this->conn->query($sql);
        $this->getQuery = $sql;
        if($query){
            $this->numRows = $query->num_rows;
            for($i = 0; $i < $this->numRows; $i++){
                $r = $query->fetch_array();
                $key = array_keys($r);
                for($x = 0; $x < count($key); $x++){
                    if(!is_int($key[$x])){
                        if($query->num_rows >= 1){
                            $this->response[$i][$key[$x]] = $r[$key[$x]];
                        }else{
                            $this->response = null;
                        }
                    }
                }
            }
            return true;
        }else{
            $this->error();
        }
	}

    /*
     * Database Select
     */
    public function select($table, $rows = '*', $join = null, $where = null, $like = null, $order = null, $limit = null){
        $q = 'SELECT '.$rows.' FROM '.$table;
        if($join != null){
            $q .= ' JOIN '.$join;
        }
        if($where != null){
            $q .= ' WHERE '.$where;
        }
        if($like != null){
            $q .= ' LIKE '.$like;
        }
        if($order != null){
            $q .= ' ORDER BY '.$order;
        }
        if($limit != null){
            $q .= ' LIMIT '.$limit;
        }

        $this->getQuery = $q;
        if($this->tableExists($table)){
            $query = $this->conn->query($q);
            if($query){
                $this->numRows = $query->num_rows;
                for($i = 0; $i < $this->numRows; $i++){
                    $r = $query->fetch_array();
                    $key = array_keys($r);
                    for($x = 0; $x < count($key); $x++){
                        if(!is_int($key[$x])){
                            if($query->num_rows >= 1){
                                $this->response[$i][$key[$x]] = $r[$key[$x]];
                            }else{
                                $this->response[$i][$key[$x]] = null;
                            }
                        }
                    }
                }
                return true;
            }else{
                $this->error();
            }
        }else{
            return false;
        }
    }

    /*
     * Database Insert
     */
    public function insert($table,$params=array()){
         if($this->tableExists($table)){
            $sql='INSERT INTO `'.$table.'` (`'.implode('`, `',array_keys($params)).'`) VALUES ("' . implode('", "', $params) . '")';
            $this->getQuery = $sql;
            if($ins = $this->conn->query($sql)){
                array_push($this->response,$this->conn->insert_id);
                return true;
            }else{
                $this->error();
            }
        }else{
            return false;
        }
    }

    /*
     * Database Delete Row
     */
    public function delete($table,$where = null){
         if($this->tableExists($table)){
            if($where == null){
                $this->error();
            }else{
                $delete = 'DELETE FROM '.$table.' WHERE '.$where;
            }
            if($del = $this->conn->query($delete)){
                array_push($this->response,$this->conn->affected_rows);
                $this->getQuery = $delete;
                return true;
            }else{
                $this->error();
            }
        }else{
            return false;
        }
    }

    /*
     * Database Update Row
     */
    public function update($table,$params=array(),$where){
        if($this->tableExists($table)){
            $args=array();
            foreach($params as $field=>$value){
                $args[]=$field.'="'.$value.'"';
            }
            $sql='UPDATE '.$table.' SET '.implode(',',$args).' WHERE '.$where;
            $this->getQuery = $sql;
            if($query = $this->conn->query($sql)){
                array_push($this->response,$this->conn->affected_rows);
                return true;
            }else{
                $this->error();
            }
        }else{
            return false;
        }
    }

    /*
     * Return Data
     */
    public function getResponse(){
        $val = $this->response;
        $this->response = array();
        return $val;
    }

    /*
     * SQL debug
     */
    public function getSql(){
        $val = $this->getQuery;
        $this->getQuery = array();
        return $val;
    }

    /*
     * Number of rows back
     */
    public function numRows(){
        $val = $this->numRows;
        $this->numRows = array();
        return $val;
    }

    /*
     * Escape strings
     */
    public function escapeString($data){
        return $this->conn->real_escape_string($data);
    }

    /*
     * Error
     */
    public function error(){
        array_push($this->response,$this->conn->error);
        return false;
    }
}
