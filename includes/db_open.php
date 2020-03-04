<?php
    $mydbhost = "__DBHOST__";
    $mydatabase = "__DBNAME__";
    $mydbuserid = "__DBUSER__";
    $mydbpassword = "__DBPW__";

    $database = mysqli_connect($mydbhost, $mydbuserid, $mydbpassword, $mydatabase);
    if(mysqli_connect_errno()) {
        echo "Failed to connect to database.";
        die(mysqli_connect_error());
    }
?>
