<?php
session_start();
require_once('./connection.php'); 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['register'])) {

        $user_name = $_POST['username'];
        $user_email = $_POST['email'];
        $user_pwd = $_POST['password']
    }

    //validate username
    if ($username === "") {
        $_SESSION['error'][] = "Your Username Is Empty!";
    }
    else if (strlen($username) < 3 || strlen($username) > 10) {
        $_SESSION['error'][] = "Username length should be between 3 and 10
        character long";
    }

    //validate email
    $email_regex = “/([a-zA-Z0-9!#$%&’?^_`~-])+@([a-zA-Z0-9-])+(.com)+/”;
    if()

}





