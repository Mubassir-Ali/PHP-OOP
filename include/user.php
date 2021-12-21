<?php
require_once('database.php');
require_once('database_object.php');

class User extends DatabaseObject{
    public $id;
    public $username;
    public $password;
    public $first_name;
    public $last_name;

    public static function find_all(){
        // global $database;
        // $result_set=$database->query("SELECT * FROM users");        
        // return $result_set;

        return self::find_by_sql('SELECT * FROM users');
    }

    public static function find_by_id($id=0){
        // global $database;
        // $result_set =$database->query("SELECT * FROM users WHERE id={$id}");
        // $found=$database->fetch_array($result_set);     
        // return $found;
        $result_array=self::find_by_sql("SELECT * FROM users WHERE id={$id} LIMIT 1");
        return !empty($result_array) ? array_shift($result_array) : false ;

       
    }

    public static function find_by_sql($sql=""){
        global $database;
        $result_set =$database->query($sql);

        $object_array=array();
        while($row=$database->fetch_array($result_set)){
            $object_array[]=self::instantiate($row);
        }

        return $object_array;
    }

    public function full_name(){
        if(isset($this->first_name) && isset($this->last_name)){
            return $this->first_name . " " . $this->last_name;
        }else{
            return "";
        }
    }

    public static function authenticate($username="", $password=""){
        global $database;
        $username=$database->escape_value($username);
        $password=$database->escape_value($password);


        $sql="SELECT * FROM users WHERE username='{$username}' AND password='{$password}' LIMIT 1";

        $result_array=self::find_by_sql($sql);
        return !empty($result_array)? array_shift($result_array):false;


    }

    private static function instantiate($record){
        // $object =new User();
        // $object->id=$record['id'];
        // $object->usename=$record['objectname'];
        // $object->password=$record['password'];
        // $object->first_name=$record['first_name'];
        // $object->last_name=$record['last_name'];
        
        // More dynamic, short-form approach
        $object =new self();        
        foreach($record as $attribute=>$value){
            if($object->has_attribule($attribute)){
                $object->$attribute=$value;             

            }
        }

        return $object;
    }

    private function has_attribule($attribute){
        $object_vars =get_object_vars($this);
        return array_key_exists($attribute,$object_vars);
    }





}




?>