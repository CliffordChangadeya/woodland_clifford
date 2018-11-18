<?php
    session_start();
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db = "woodland";
    $dbh = mysql_connect($host, $user, $pass)
    or die ("Couldn't connect to database");
    mysql_select_db($db);
    if(isset($_SESSION['userid'])){
        $userxid = $_SESSION['userid'];
    }
    
?>