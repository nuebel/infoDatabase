<?php
    require_once('DB.php');
    $mydbhost = "__DBHOST__";
    $mydatabase = "__DB__";
    $mydbuserid = "__DBUSER__";
    $mydbpassword = "__DBPW__";
    $database = DB::connect( "mysql://".$mydbuserid.":".$mydbpassword."@".$mydbhost."/".$mydatabase );
    if (PEAR::isError($database)) {echo "Error."; die($database->getMessage());}
?>
