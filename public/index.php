<?php 
    require_once('../include/database.php');
    require_once('../include/user.php');

    if(isset($database)){echo "true";}else{echo "false";}
    echo "<br/>";




//     $sql="INSERT INTO users(username,password,first_name,last_name) VALUES ('mubassir11','secret','Mubassir','Ali')";

//    $result =$database->query($sql);

    $sql1="SELECT * FROM users WHERE id=1";
    $result_set =$database->query($sql1);

    $found_user=$database->fetch_array($result_set);

    echo $found_user['username'];

    echo "<hr/>";

    // $user=new User();
    // $found_user=$user->find_by_id(1);
    // echo $found_user['first_name'];

    $found_user =User::find_by_id(1);
    echo $found_user['username'];

    echo "<hr/>";

    $user_set=User::find_all();
    while($user=$database->fetch_array($user_set)){
        echo "User: ".$user['username']."<br/>";
        echo "first Name: ".$user['first_name']."<br/>";
        echo "last Name: ".$user['last_name']."<br/>";
        
    }


?>