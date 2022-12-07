<?php
    require_once(../config/connection.php);
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        if (isset($_POST['username']) && isset($_POST['password'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];
    
            $hash = password_hash($password, PASSWORD_DEFAULT);
    
            $query = "SELECT * FROM users WHERE username = '$username'";
            $res = $connection->query($query);

            if($row = $res->fetch_assoc()) {
                //data dpt, mo diapain
                
            }
            else {
                echo("Wrong Password and Username");
                die;
            }
        }
    }
    else if($_SERVER['REQUEST_METHOD'] == "GET") {

    }
