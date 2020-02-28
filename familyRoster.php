<?php
include 'verifyDbLogin.php';
include 'includes/db_open.php';
session_start();

    $queryStr = "SELECT * FROM " . $_SESSION['directoryTable'] . " WHERE color='" . $_REQUEST['color'] . "' ";
    $topMessage = ucwords($_REQUEST['color']) . " Family";

    if ($_REQUEST['sortBy'] == 'first_name') {
        $queryStr .= " ORDER BY first_name, last_name";
        $topMessage .= " sorted by first name";
    } else if ($_REQUEST['sortBy'] == 'class') {
        $queryStr .= " ORDER BY class, last_name";
        $topMessage .= " sorted by class";
    } else if ($_REQUEST['sortBy'] == 'color') {
        $queryStr .= " ORDER BY color, last_name";
        $topMessage .= " sorted by family";
    } else if ($_REQUEST['sortBy'] == 'address') {
        $queryStr .= " ORDER BY on_campus, street_local, streetNum_local";
        $topMessage .= " sorted by address";
    } else {
        $queryStr .= " ORDER BY last_name, first_name";
        $topMessage .= " sorted by last name";
    }

    //Store the query string to the session
    $_SESSION['query'] = $queryStr;
    $_SESSION['message'] = $topMessage;

    $result = $database->query($queryStr);
    $rows = $result->numRows();
?>

<html>
    <head>
        <link href="../style.css" rel="stylesheet" type="text/css" />
        <link href="./directory.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript">
          function DoNav(theUrl) {
            document.location.href = theUrl;
          }
        </script>
    </head>
    <body>
        <h4><?php echo $topMessage?></h4>
        <div id="directory">
            <table>
                <tr>
                    <th colspan="2">Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Class</th>
                </tr>
            <?php
                for ($i=0; $i < $rows; $i++) {
                    $data = $result->fetchRow(DB_FETCHMODE_ASSOC, $i);
                    $address = $data['streetNum_local'] . ' ' . $data['street_local'];
                    if ($i % 2 == 1) echo "<tr class='shaded' ";
                    else echo "<tr ";
                    echo "onclick=DoNav('displayPerson.php?id=" . $data['id'] . "');>";
                    echo "<td>" . $data['first_name'] . "</td>";
                    echo "<td>" . $data['last_name'] . "</td>";
                    echo "<td>" . $data['email'] . "</td>";
                    echo "<td>" . $data['phone'] . "</td>";
                    echo "<td>$address</td>";
                    echo "<td>" . $data['class'] . "</td></tr>";
                }
            ?>
            </table>
        </div>
        <div class="clearing"></div>
    </body>
</html>