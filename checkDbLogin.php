<?php
include 'includes/db_open.php';

$myusername=$_POST['username'];
$mypassword=$_POST['password'];

// To protect MySQL injection
$myusername = stripslashes($myusername);
$mypassword = stripslashes($mypassword);
$myusername = mysql_real_escape_string($myusername);
$mypassword = mysql_real_escape_string($mypassword);

$queryStr = "SELECT * FROM bcm_students_login WHERE username='$myusername' and password='$mypassword'";
$result = $database->query($queryStr);

$count = $result->numRows();

if ($count == 1){
	$data = $result->fetchRow(DB_FETCHMODE_ASSOC, 0);
    //Register user name
    session_start();
    $_SESSION['username'] = $data['username'];

    //Set session database tables
    $mydb = $data['defaultTable'];
    $dbQuery = "SELECT * FROM directory_tables WHERE tableName='" . $mydb . "'";
    $dbResult = $database->query($dbQuery);
    $dbCount = $dbResult->numRows();

    if ($dbCount == 1) {
    	$dbData = $dbResult->fetchRow(DB_FETCHMODE_ASSOC, 0);
    	//Set default database table for directory
		$_SESSION['directoryTable'] = $dbData['tableName'];
		$_SESSION['directoryAttTable'] = $dbData['attTableName'];
    	$_SESSION['directoryTitle'] = $dbData['title'];

    	//Redirect
    	header("location:dbSearch.php");
    } else {
        echo "<h4>User Has Incorrect Default Table</h4>";
    	echo "<a href='dbLogin.php'>Back to Login Page</a>";
    }

} else {
    echo "<h4>Wrong Username or Password</h4>";
    echo "<a href='dbLogin.php'>Back to Login Page</a>";
}
?>
</body>
</html>