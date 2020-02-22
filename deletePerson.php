<?php
include 'verifyDbLogin.php';
include 'includes/db_open.php';

    session_start();
    $deleteQuery = "DELETE FROM " . $_SESSION['directoryTable'] . " WHERE id='" . $_REQUEST['id'] . "'";
    $database->query($deleteQuery);
    $attQuery = "DELETE FROM " . $_SESSION['directoryAttTable'] . " WHERE id='" . $_REQUEST['id'] . "'";
    $database->query($attQuery);
    $database->commit();

?>

<html>
    <head>
        <link href="./directory.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <h2>Successfully Deleted Student</h2>
        <ul id="options">
            <li><a href="dbSearch.php">Back to List</a></li>
        </ul>
    </body>
</html>