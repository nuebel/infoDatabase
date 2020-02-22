<?php
    require_once('DB.php');
    $mydbhost = "database.hosting.vt.edu";
    $mydatabase = "database372";
    $mydbuserid = "site372";
    $mydbpassword = "WAZJEFFF";
    $database = DB::connect( "mysql://".$mydbuserid.":".$mydbpassword."@".$mydbhost."/".$mydatabase );
    if (PEAR::isError($database)) {echo "Error."; die($database->getMessage());}
?>
