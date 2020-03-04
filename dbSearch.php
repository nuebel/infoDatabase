<?php
    include 'verifyDbLogin.php';
    include 'includes/db_open.php';

    session_start();
    $queryStr = "SELECT * FROM " . $_SESSION['directoryTable'];
    $topMessage = "All Students";

    if ($_REQUEST['back'] == 'true') {
        $queryStr = $_SESSION['query'];
        $topMessage = $_SESSION['message'];
    } else {

        if (isset($_REQUEST['first_name'])) {
            $queryStr .= " WHERE first_name LIKE '%" . $_REQUEST['first_name'] . "%'";
            $topMessage = "Students with first name \"" . $_REQUEST['first_name'] . "\"";
        } else if (isset($_REQUEST['last_name'])) {
            $queryStr .= " WHERE last_name LIKE '%" . $_REQUEST['last_name'] . "%'";
            $topMessage = "Students with last name \"" . $_REQUEST['last_name'] . "\"";
        } else if (isset($_REQUEST['email'])) {
            $queryStr .= " WHERE email LIKE '%" . $_REQUEST['email'] . "%'";
            $topMessage = "Students with email \"" . $_REQUEST['email'] . "\"";
        } else if (isset($_REQUEST['color'])) {
            $queryStr .= " WHERE color LIKE '%" . $_REQUEST['color'] . "%'";
            $topMessage = "Students in " . $_REQUEST['color'] . " family";
        } else if (isset($_REQUEST['class'])) {
            $queryStr .= " WHERE class LIKE '%" . $_REQUEST['class'] . "%'";
            $topMessage = "Students in " . $_REQUEST['class'] . " class";
        } else if (isset($_REQUEST['major'])) {
            $queryStr .= " WHERE major LIKE '%" . $_REQUEST['major'] . "%'";
            $topMessage = "Students with major \"" . $_REQUEST['major'] . "\"";
        } else if (isset($_REQUEST['dorm'])) {
            $queryStr .= " WHERE street_local LIKE '%" . $_REQUEST['dorm'] . "%' AND on_campus='true'";
            $topMessage = "Students in dorm \"" . $_REQUEST['dorm'] . "\"";
        } else if (isset($_REQUEST['homeAdd'])) {
            $queryStr .= " WHERE street_perm LIKE '%" . $_REQUEST['homeAdd'] . "%' OR city_perm LIKE '%" . $_REQUEST['homeAdd'] . "%' OR state_perm LIKE '%" . $_REQUEST['homeAdd'] . "%' OR zip_perm LIKE '%" . $_REQUEST['homeAdd'] . "%'";
            $topMessage = "Students with home address \"" . $_REQUEST['homeAdd'] . "\"";
        } else if (isset($_REQUEST['church'])) {
            $queryStr .= " WHERE church LIKE '%" . $_REQUEST['church'] . "%'";
            $topMessage = "Students from church \"" . $_REQUEST['church'] . "\"";
        } else if (isset($_REQUEST['other'])) {
            $queryStr .= " WHERE other LIKE '%" . $_REQUEST['other'] . "%'";
            $topMessage = "Students with notes containing \"" . $_REQUEST['other'] . "\"";
        } else if (isset($_REQUEST['gender'])) {
            $queryStr .= " WHERE gender='" . $_REQUEST['gender'] . "'";
            if ($_REQUEST['gender'] == 'm') $topMessage = "Male Students";
            else if ($_REQUEST['gender'] == 'f') $topMessage = "Female Students";
        } else if (isset($_REQUEST['onCampus'])) {
            $queryStr .= " WHERE on_campus='true'";
            $topMessage = "On Campus Students";
        } else if (isset($_REQUEST['onCampus_gender'])) {
            $queryStr .= " WHERE gender='" . $_REQUEST['onCampus_gender'] . "' AND on_campus='true'";
            if ($_REQUEST['onCampus_gender'] == 'm') $topMessage = "Male On Campus Students";
            else if ($_REQUEST['onCampus_gender'] == 'f') $topMessage = "Female On Campus Students";
        }

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
    }

    //Store the query string to the session
    $_SESSION['query'] = $queryStr;
    $_SESSION['message'] = $topMessage;

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
        </script>
    </head>
    <body>
        <!--queryStr is <?php echo $queryStr;?> -->
        <h4><?php echo $topMessage; ?> - Results: <?php echo $rows;?>&nbsp;|&nbsp;Database: <?php echo $_SESSION['directoryTitle'];?></h4>
        <div id="directory">
            <table>
                <tr>
                    <th colspan="2">Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>School Address</th>
                    <?php if (isset($_REQUEST['homeAdd'])) echo "<th>Home Address</th>"; ?>
                    <th>Family</th>
                    <?php if (isset($_REQUEST['major'])) echo "<th>Major</th>"; ?>
                    <?php if (isset($_REQUEST['church'])) echo "<th>Church</th>"; ?>
                    <th>Class</th>
                </tr>
            <?php
                for ($i=0; $i < $rows; $i++) {
                    $data = $result->fetch_assoc();
                    $address = $data['streetNum_local'] . ' ' . $data['street_local'];
                    $homeAddress = $data['street_perm'] . ' ' . $data['city_perm'] . ', ' . $data['state_perm'] . ' ' . $data['zip_perm'];
                    $phoneNumber = $data['phone'];
					$phoneStr = $phoneNumber;
                	if (strlen($phoneStr) == 10) $phoneStr = substr($phoneNumber, 0, 3) . "-" . substr($phoneNumber, 3, 3) . "-" . substr($phoneNumber, 6);
                    if ($i % 2 == 1) echo "<tr class='shaded' ";
                    else echo "<tr ";
                    echo "onclick=DoNav('./displayPerson.php?id=" . $data['id'] . "');>";
                    echo "<td>" . $data['first_name'] . "</td>";
                    echo "<td>" . $data['last_name'] . "</td>";
                    echo "<td>" . $data['email'] . "</td>";
                    echo "<td>" . $phoneStr . "</td>";
                    echo "<td>$address</td>";
                    if (isset($_REQUEST['homeAdd'])) echo "<td>" . $homeAddress . "</td>";
                    echo "<td>" . $data['color'] . "</td>";
                    if (isset($_REQUEST['major'])) echo "<td>" . $data['major'] . "</td>";
                    if (isset($_REQUEST['church'])) echo "<td>" . $data['church'] . "</td>";
                    echo "<td>" . $data['class'] . "</td></tr>";
                }
            ?>
            </table>
        </div>
        <div class="clearing"></div>
    </body>
</html>