<?php

    $host = "localhost";
    $dbuser = "root";
    $pwd = "";
    $dbname = "myassignmentdb";

    $con = mysqli_connect($host, $dbuser, $pwd, $dbname);

    if(!$con){
        echo "<h3>Database conection error.</h3>";
        die();
    }

?>