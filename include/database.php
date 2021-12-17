<?php

require_once('config.php');

class MySQLDatabase{
    private $connection;

    function __construct()
    {
        $this->open_connection();
    }

    public function open_connection(){      
        $this->connection=new mysqli(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
        if($this->connection->connect_error){
            die("Database connection failed: ". $this->connection->connect_error);
        }
    }

    public function close_connection(){
        if(isset($this->connection)){
            mysqli_close($this->connection);
            unset($this->connection);
        }
    }

    public function query($sql){
        $result =mysqli_query($this->connection,$sql);
        $this->confirm_query($result);
        return $result;
    }

  

    public function escape_value($value){     
        $value =mysqli_real_escape_string($this->connection,$value);        
        return $value;

    }

    public function fetch_array($result){
        return mysqli_fetch_array($result);
    }

    private function confirm_query($result){
        if(!$result){
            die("Database query failed: ".mysqli_error($this->connection));
        }
    }

    public function num_rows($result_set){
        return mysqli_num_rows($result_set);
    }

    public function insert_id(){
        // get the last id inserted over the current db connection
        return mysqli_insert_id($this->connection);
    }

    public function affected_rows(){
        return mysqli_affected_rows($this->connection);
    }

}

$database=new MySQLDatabase();


$db=& $database;


?>