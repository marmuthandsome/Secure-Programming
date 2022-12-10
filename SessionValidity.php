<?php

function SessionValidity()
{
    if ($_SESSION['is_login'] == false || !isset($_SESSION['is_login'])) {
        // redirect user back to login
        session_unset();
        session_destroy();
        header('Location: login.php');
    }
    // checking more than 1 hours
    elseif ((time() - strtotime($_SESSION['lastlogin']) > 3600)) {
        session_unset();
        session_destroy();
        header('Location: login.php');
    }
}
