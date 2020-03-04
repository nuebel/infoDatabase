<?php
include 'verifyDbLogin.php';
include 'includes/db_open.php';

session_start();

    $message = "";
    if (isset($_REQUEST['formAction'])) {
        if ($_REQUEST['formAction'] == 'updateTable') {
            $queryStr = "SELECT * FROM directory_tables WHERE id='" . $_REQUEST['updateDb'] . "'";
            $result = $database->query($queryStr);
            $rows = $result->num_rows;
            if ($rows != 1) $message = "Error:";
            else {
                $data = $result->fetch_assoc();
                $_SESSION['directoryTable'] = $data['tableName'];
                $_SESSION['directoryAttTable'] = $data['attTableName'];
                $_SESSION['directoryTitle'] = $data['title'];
                $message = "Database Changed!";
            }
        }
    }

?>

<html>
    <head>
        <link href="./directory.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript">
          function DoNav(theUrl) {
            document.location.href = theUrl;
          }
        </script>
    </head>
    <body>
        <?php if ($message != "") echo "<h4>$message</h4>";?>
        <h3>Change Directory Database</h3>
        <h4>Current Directorty: <?php echo $_SESSION['directoryTitle'];?></h4>
        Table: <?php echo $_SESSION['directoryTable'];?><br/>
        Attendance Table: <?php echo $_SESSION['directoryAttTable'];?><br/>
        <form name="database_form" method="post" action="changeDatabase.php">
            <input type="hidden" name="formAction" id="formAction" value="updateTable"/>
            New Directory Database:&nbsp;
            <select name="updateDb">
                <?php
                    $queryStr = "SELECT * FROM directory_tables ORDER BY title";
                    $result = $database->query($queryStr);
                    $rows = $result->num_rows;

                    for ($i=0; $i<$rows; $i++) {
                        $data = $result->fetch_assoc();
                        echo "<option value='" . $data['id'] . "'>" . $data['title'] . "</option>";
                    }
                ?>
            </select>
            <input type="submit" value="Change"/>
        </form>

        <div class="clearing"></div>
    </body>
</html>