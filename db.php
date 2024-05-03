<?php

class my_database
{

    public $connection_database;

    public function __construct()
    {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "sad-db";

// Create connection
        $this->connection_database = new mysqli($servername, $username, $password, $dbname);
// Check connection
        if ($this->connection_database->connect_error) {
            die("Connection failed: " . $this->connection_database->connect_error);
        }
        else{
            //echo "ارتباط با دیتابیس موفق میباشد";
            //die();
        }
    }




}