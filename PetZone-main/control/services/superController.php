<?php
session_status() === PHP_SESSION_ACTIVE ?: session_start();
require_once("../../Dbh.php");
abstract class SuperController{
    protected $db;
    protected $conn;

    public function connect(){
        if(null === $this->conn ){
            $this->db = new Dbh();
        }
        return $this->db;
    }
}
?>