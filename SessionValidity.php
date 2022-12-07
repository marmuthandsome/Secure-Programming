<?php

function SessionValidity()
{
    if ($_SESSION['is_login'] == false || !isset($_SESSION['is_login'])) {
        // redirect user back to login
        session_unset();
        session_destroy();
        header('Location: login.php');
    }
    // macthing ip adr
    elseif (
        $_SERVER['REMOTE_ADDR'] != $_SESSION['ipadr'] &&
        $_SERVER['HTTP_USER_AGENT'] != $_SESSION['browser']
    ) {
        session_unset();
        session_destroy();
        header('Location: login.php');
    }
    // checking more than 12 hours
    elseif ((time() - strtotime($_SESSION['lastlogin']) > (12 * 60 * 60))) {
        session_unset();
        session_destroy();
        header('Location: login.php');
    }
}
