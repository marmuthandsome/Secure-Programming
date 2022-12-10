<?php
session_start();
if (isset($_POST['register'])) {
    $user_name = $_POST['username'];
    $user_email = $_POST['email'];
    $user_pwd = $_POST['password'];
    $user_Conpwd = $_POST['confirmpassword'];

    $error = false;
    $msg = [];

    //validate username
    if ($user_name === "") {
        $msg['username'] = "Your Username Is Empty!";
        $error = true;
    } else if (strlen($user_name) < 3 || strlen($user_name) > 10) {
        $msg['username'] = "Username length should be between 3 and 10
        character long";
        $error = true;
    }

    //validate email
    if ($user_email === "") {
        $msg['email'] = "Your Email Is Empty!";
        $error = true;
    } else if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
        $msg['email'] = "Email Not Valid";
        $error = true;
    }

    //filter password
    $number = preg_match('@[0-9]@', $user_pwd);
    $upper_case = preg_match('@[A-Z]@', $user_pwd);
    $special_Char = preg_match('@[^\w]@', $user_pwd);

    if ($user_pwd === "") {
        $msg['password'] = "Your Password Is Empty!";
        $error = true;
    } else if (strlen($user_pwd) < 10 || !$number || !$upper_case || !$special_Char) {
        $msg['password'] = "Password Must Be At Least 10 Characters And Contains Number,Uppercase, and Special Characters";
        $error = true;
    } else {
        $confirm_pwd = $user_pwd;
    }

    //filter confirm password
    if ($user_Conpwd === "") {
        $msg['confirm'] = "Confirm Password Is Empty!";
        $error = true;
    } else if ($user_Conpwd != $user_pwd) {
        $msg['confirm'] = "Wrong Confirm Password";
        $error = true;
    }

    if (!$error) {
        $_POST["username"] = htmlspecialchars($_POST["username"]);
        $_POST["password"] = htmlspecialchars($_POST["password"]);
        $_POST["email"] = htmlspecialchars($_POST["email"]);
        $_POST["address"] = htmlspecialchars($_POST["address"]);
        $_POST["password"] = password_hash($_POST['password'], PASSWORD_BCRYPT, array("cost" => 11));
        $query = "INSERT INTO users (username, password, email, gender, address) VALUES (:username,:password,:email,:gender,:address)";
        $statement = $connect->prepare($query);
        $statement->bindParam(':username', $_POST["username"], PDO::PARAM_STR);
        $statement->bindParam(':password', $_POST["password"], PDO::PARAM_STR);
        $statement->bindParam(':email', $_POST["email"], PDO::PARAM_STR);
        $statement->bindParam(':gender', $_POST["gender"], PDO::PARAM_STR);
        $statement->bindParam(':address', $_POST["address"], PDO::PARAM_STR);
        $statement->execute();
    } else {
        $_SESSION['error'] = $msg;
    }
}
