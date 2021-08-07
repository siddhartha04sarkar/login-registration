<?php
    include("connection.inc.php");
    session_start();

    unset($_SESSION["USER_LOGIN"]);
    unset($_SESSION["USERID"]);
    unset($_SESSION["USERNAME"]);
    unset($_SESSION["USEREMAIL"] );

    header("location:login.php");
    die();
?>