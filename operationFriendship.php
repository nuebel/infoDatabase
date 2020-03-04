<?php
include 'verifyDbLogin.php';
include 'includes/db_open.php';
session_start();

    //Check to see if there is an update coming from displayOF.php
    if ($_REQUEST['updateRecord'] == 'true') {
        $updateQuery = "UPDATE " . $_SESSION['directoryTable'];
        $updateQuery .= " SET operation_friendship = '" . $_REQUEST['operation_friendship'] . "'";
        $updateQuery .= " WHERE id = '" . $_REQUEST['id'] . "'";
        $database->query($updateQuery);
        $database->commit();
    }

    $queryStr = "SELECT * FROM " . $_SESSION['directoryTable'] . " WHERE prospect='true' ";
    if ($_REQUEST['sortBy'] == 'operation_friendship') $queryStr .= " ORDER BY operation_friendship, last_name";
    else $queryStr .= "ORDER BY zip_perm, last_name";

    //Store the query string to the session
    $_SESSION['query'] = $queryStr;


    $result = $database->query($queryStr);
    $rows = $result->num_rows;
?>

<html>
    <head>
        <link href="./directory.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript">
          function DoNav(theUrl) {
            document.location.href = theUrl;
          }

          function sort(new_sortBy) {
            var url = "operationFriendship.php?sortBy=" + new_sortBy;
            DoNav(url);
            }
        </script>
    </head>
    <body>
        <h3>Operation Friendship</h3>
        <div id="of_sort">
            Sort by:&nbsp;
            <a href="#" onclick="sort('zip_perm');">Zip Code</a>
            &nbsp;|&nbsp;<a href="#" onclick="sort('operation_friendship');">Operation Friendship Name</a>
        </div>
        <div id="directory">
            <table>
                <tr>
                    <th colspan="2">Name</th>
                    <th>Email</th>
                    <th>Home Address</th>
                    <th>Operation Friendship</th>
                </tr>
            <?php
                for ($i=0; $i < $rows; $i++) {
                    $data = $result->fetch_assoc();
                    $address = $data['street_perm'] . ' ' . $data['city_perm'] . ', ' . $data['state_perm'] . ' ' . $data['zip_perm'];
                    if ($i % 2 == 1) echo "<tr class='shaded' ";
                    else echo "<tr ";
                    echo "onclick=DoNav('displayOF.php?id=" . $data['id'] . "');>";
                    echo "<td>" . $data['first_name'] . "</td>";
                    echo "<td>" . $data['last_name'] . "</td>";
                    echo "<td>" . $data['email'] . "</td>";
                    echo "<td>$address</td>";
                    echo "<td>" . $data['operation_friendship'] . "</td></tr>";
                }
            ?>
            </table>
        </div>
        <div class="clearing"></div>
    </body>
</html>