<?php
include "Database.php";
class Model{
    public $db;

    public function __construct(){
        $database = new Database();
        return $this->db = $database->connect();
    }
}