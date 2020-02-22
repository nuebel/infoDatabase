<?php
include 'verifyDbLogin.php';
include 'includes/db_open.php';
session_start();

    if ($_REQUEST['updateRecord'] == 'true') {
        $message = "Updated Student Information";
        $theID = $_REQUEST['id'];

        $updateQuery = "UPDATE " . $_SESSION['directoryTable'];
        $updateQuery .= " SET first_name = '" . $_REQUEST['first_name'] . "'";
        $updateQuery .= ", last_name = '" . $_REQUEST['last_name'] . "'";
        $updateQuery .= ", class = '" . $_REQUEST['class'] . "'";
        $updateQuery .= ", gender = '" . $_REQUEST['gender'] . "'";
        $updateQuery .= ", color = '" . $_REQUEST['color'] . "'";
        $updateQuery .= ", phone = '" . $_REQUEST['phone'] . "'";
        $updateQuery .= ", email = '" . $_REQUEST['email'] . "'";
        $updateQuery .= ", on_campus = '" . $_REQUEST['on_campus'] . "'";
        $updateQuery .= ", streetNum_local = '" . $_REQUEST['streetNum_local'] . "'";
        $updateQuery .= ", street_local = '" . $_REQUEST['street_local'] . "'";
        $updateQuery .= ", street_perm = '" . $_REQUEST['street_perm'] . "'";
        $updateQuery .= ", city_perm = '" . $_REQUEST['city_perm'] . "'";
        $updateQuery .= ", state_perm = '" . $_REQUEST['state_perm'] . "'";
        $updateQuery .= ", zip_perm = '" . $_REQUEST['zip_perm'] . "'";
        $updateQuery .= ", major = '" . $_REQUEST['major'] . "'";
        $updateQuery .= ", church = '" . $_REQUEST['church'] . "'";
        $updateQuery .= ", prospect = '" . $_REQUEST['prospect'] . "'";
        $updateQuery .= ", info_card = '" . $_REQUEST['info_card'] . "'";
        $updateQuery .= ", other = '" . $_REQUEST['other'] . "'";
        $updateQuery .= " WHERE id = '" . $_REQUEST['id'] . "'";
        $database->query($updateQuery);
        $database->commit();
    } else if ($_REQUEST['newRecord'] == 'true') {
        $message = "Added New Student";
        //$bday = date('Y-m-d', strtotime($_REQUEST['birthdate']));
        $addQuery = "INSERT INTO " . $_SESSION['directoryTable'];
        $addQuery .= " (first_name, last_name, class, gender, color, phone, email, ";
        $addQuery .= "on_campus, streetNum_local, street_local, street_perm, ";
        $addQuery .= "city_perm, state_perm, zip_perm, major, church, ";
        $addQuery .= "prospect, info_card, other) ";
        $addQuery .= "VALUES ('$_REQUEST[first_name]', '$_REQUEST[last_name]', ";
        $addQuery .= "'$_REQUEST[class]', '$_REQUEST[gender]', '$_REQUEST[color]', ";
        $addQuery .= "'$_REQUEST[phone]', '$_REQUEST[email]', '$_REQUEST[on_campus]', ";
        $addQuery .= "'$_REQUEST[streetNum_local]', '$_REQUEST[street_local]', '$_REQUEST[street_perm]', ";
        $addQuery .= "'$_REQUEST[city_perm]', '$_REQUEST[state_perm]', '$_REQUEST[zip_perm]', ";
        $addQuery .= "'$_REQUEST[major]', '$_REQUEST[church]', '$_REQUEST[prospect]', '$_REQUEST[info_card]', '$_REQUEST[other]')";
        $database->query($addQuery);
        $database->commit();

        //Get the ID from the row we just inserted so it can go into the attendance table
        $idQuery = "SELECT id FROM " . $_SESSION['directoryTable'] . " WHERE last_name='" . $_REQUEST['last_name'] .
            "' AND first_name='" . $_REQUEST['first_name'] . "' ORDER BY id DESC";
        $result = $database->query($idQuery);
        $data = $result->fetchRow(DB_FETCHMODE_ASSOC, 0);
        $newID = $data['id'];

        //Insert into the attendance table
        $attQuery = "INSERT INTO " . $_SESSION['directoryAttTable'] . " (studentID) VALUES ('$newID')";
        $database->query($attQuery);
        $database->commit();

        $theID = $newID;
    } else {
        $message = "View Student Information";
        $theID = $_REQUEST['id'];
    }

    $queryStr = "SELECT * FROM " . $_SESSION['directoryTable'] . ", " . $_SESSION['directoryAttTable']
     . " WHERE " . $_SESSION['directoryTable'] . ".id='" . $theID . "' "
     . " AND " . $_SESSION['directoryAttTable'] . ".studentID = " . $_SESSION['directoryTable'] . ".id ";

    $result = $database->query($queryStr);
    $rows = $result->numRows();
?>

<html>
    <head>
        <link href="./directory.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript">
          function confirmDelete() {
              return confirm("Are you sure you want to delete this person from the database?");
          }
        </script>
    </head>
    <body>
        <?php if ($rows != 1) echo "<h1>Student Not Found!</h1>";
            else {
                $data = $result->fetchRow(DB_FETCHMODE_ASSOC, 0);
                $phoneNumber = $data['phone'];
                $phoneStr = $phoneNumber;
                if (strlen($phoneStr) == 10) $phoneStr = substr($phoneNumber, 0, 3) . "-" . substr($phoneNumber, 3, 3) . "-" . substr($phoneNumber, 6);

        ?>
        <h2><?php echo $message; ?></h2>
        <div id="person">
            <div id="name"><div class="label">Name:</div> &nbsp; <?php echo $data['first_name'] . ' ' . $data['last_name']; ?></div>
            <div id="class"><div class="label">Class:</div> &nbsp; <?php echo $data['class']; ?></div>
            <div id="gender"><div class="label">Gender:</div> &nbsp; <?php if ($data['gender'] == 'm') echo "M"; else echo "F";?></div>
            <div id="family"><div class="label">Family Group:</div> &nbsp; <span style="font-weight: bold; color: <?php echo $data['color']; ?>"><?php echo $data['color']; ?></span></div>
            <div id="prospect"><div class="label">Prospect?</div> &nbsp; <?php if ($data['prospect'] == 'true') echo "Yes"; else echo "No";?></div>
            <div id="phone"><div class="label">Phone:</div> &nbsp; <?php echo $phoneStr; ?></div>
            <div id="email"><div class="label">Email:</div> &nbsp; <?php echo $data['email']; ?></div>
            <div id="info_card"><div class="label">Info Card?</div> &nbsp; <?php if ($data['info_card'] == 'true') echo "Yes"; else echo "No";?></div>
            <div id="schoolAddress"><div class="label">School Address:</div> &nbsp; <?php echo $data['streetNum_local'] . ' ' . $data['street_local']; ?></div>
            <div id="homeAddress"><div class="label">Home Address:</div> &nbsp; <?php echo $data['street_perm'] . ' ' . $data['city_perm'] . ', ' . $data['state_perm'] . ' ' . $data['zip_perm']; ?></div>
            <div id="major"><div class="label">Major:</div> &nbsp; <?php echo $data['major']; ?></div>
            <div id="church"><div class="label">Church:</div> &nbsp; <?php echo $data['church']; ?></div>
            <div id="other"><div class="label">Notes:</div> &nbsp; <?php echo $data['other']; ?></div>

            <div id="bsAttendance">
                <div class="label">Bible Study Attendance:</div>
                <div id="dirNoLink">
                <table>
                    <tr><th>Week:</th><th>1</th><th>2</th><th>3</th><th>4</th><th>5</th><th>6</th><th>7</th>
                        <th>8</th><th>9</th><th>10</th><th>11</th><th>12</th><th>13</th><th>14</th><th>15</th></tr>
                    <tr>
                        <th>Fall</th>
                        <?php
                            for ($j = 1; $j <= 15; $j++) {
                                echo "<td>";
                                $varName = "week" . $j;
                                if ($data[$varName] == '1') echo 'x';
                                echo "</td>";
                            }
                        ?>
                    </tr>
                    <tr>
                        <th>Spring</th>
                        <?php
                            for ($j = 16; $j <= 30; $j++) {
                                echo "<td>";
                                $varName = "week" . $j;
                                if ($data[$varName] == '1') echo 'x';
                                echo "</td>";
                            }
                        ?>
                    </tr>
                </table>
                </div>
            </div>
        </div>
        <?php } //end else ?>
        <div class="clearing"></div>
        <ul id="options">
            <li><a href="dbSearch.php?back=true">Back to List</a></li>
            <li><a href="editPerson.php?id=<?php echo $data[id]; ?>">Edit This Person's Information</a></li>
            <li><a onclick="return confirmDelete();" href="deletePerson.php?id=<?php echo $data[id]; ?>">Delete This Person</a></li>
        </ul>
    </body>
</html>