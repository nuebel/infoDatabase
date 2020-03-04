<?php
    if ($_REQUEST['logout'] == 'true') {
        session_start();
        session_destroy();
    }
?>

<html>
    <head>
        <link href="directory.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <form name="loginForm" method="post" action="checkDbLogin.php">
            <?php if ($_REQUEST['logout'] == 'true') echo "<h4>You have been logged out of the database</h4>"; ?>
            <h3>Please login to view the database</h3>
            <div id="usernameDiv">User Name:&nbsp;<input type="text" name="username" id="username"/></div>
            <div id="passwordDiv">Password:&nbsp;<input type="password" name="password" id="password"/></div>
            <input type="submit" value="Log In"/>
        </form>
    </body>
</html>
