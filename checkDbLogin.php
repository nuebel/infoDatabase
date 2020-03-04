<?php
include 'includes/db_open.php';

$myusername=$_POST['username'];
$mypassword=$_POST['password'];

$stmt = $database->stmt_init();
if(!$stmt->prepare("SELECT * FROM students_login WHERE username=? and password=?")) {
      die("Could not prepare username statement.");
}
$stmt->bind_param("ss", $myusername, $mypassword);
$stmt->execute();
$result = $stmt->get_result();
$count = $result->num_rows;

if ($count == 1){
	$data = $result->fetch_assoc();
    //Register user name
    session_start();
    $_SESSION['username'] = $data['username'];

    //Set session database tables
    $mydb = $data['defaultTable'];
    $dbQuery = "SELECT * FROM directory_tables WHERE tableName='" . $mydb . "'";
    $dbResult = $database->query($dbQuery);
    $dbCount = $dbResult->num_rows;

    if ($dbCount == 1) {
    	$dbData = $dbResult->fetch_assoc();
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