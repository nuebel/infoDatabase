<?php
include 'verifyDbLogin.php';
include 'includes/db_open.php';
session_start();

$queryStr = "SELECT * FROM " . $_SESSION['directoryTable'] . " WHERE id='" . $_REQUEST['id'] . "'";
$result = $database->query($queryStr);
$rows = $result->num_rows;
?>

<html>
    <head>
        <link href="./directory.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript">

        </script>
    </head>
    <body>
        <?php if ($rows != 1) echo "<h1>Student Not Found!</h1>";
            else {
                $data = $result->fetch_assoc();
                $phoneNumber = $data['phone'];
                $phoneStr = $phoneNumber;
                if (strlen($phoneStr) == 10) $phoneStr = substr($phoneNumber, 0, 3) . "-" . substr($phoneNumber, 3, 3) . "-" . substr($phoneNumber, 6);
        ?>
        <h2>Operation Friendship Information</h2>
        <div id="person">
            <div id="name"><div class="label">Name:</div> &nbsp; <?php echo $data['first_name'] . ' ' . $data['last_name']; ?></div>
            <div id="class"><div class="label">Class:</div> &nbsp; <?php echo $data['class']; ?></div>
            <div id="family"><div class="label">Family Group:</div> &nbsp; <?php echo $data['color']; ?></div>
            <div id="dodgeball"><div class="label"><?php if ($data['dodgeball'] == 'true') echo "Dodgeball Contact";?></div></div>
            <div id="phone"><div class="label">Phone:</div> &nbsp; <?php echo $phoneStr; ?></div>
            <div id="email"><div class="label">Email:</div> &nbsp; <?php echo $data['email']; ?></div>
            <div id="schoolAddress"><div class="label">School Address:</div> &nbsp; <?php echo $data['streetNum_local'] . ' ' . $data['street_local']; ?></div>
            <div id="homeAddress"><div class="label">Home Address:</div> &nbsp; <?php echo $data['street_perm'] . ' ' . $data['city_perm'] . ', ' . $data['state_perm'] . ' ' . $data['zip_perm']; ?></div>
            <div id="major"><div class="label">Major:</div> &nbsp; <?php echo $data['major']; ?></div>
            <div id="church"><div class="label">Church:</div> &nbsp; <?php echo $data['church']; ?></div>
            <div id="other"><div class="label">Notes:</div> &nbsp; <?php echo $data['other']; ?></div>
        </div>

        <form name="ofForm" action="operationFriendship.php" method="post">
            <div id="operationFriendship">
                <div class="label">Operation Friendship:</div> &nbsp;
                <input type="text" name="operation_friendship" maxlength="128" value="<?php echo $data['operation_friendship']; ?>"/>
                <input type="hidden" name="id" value="<?php echo $data['id']; ?>"/>
                <input type="hidden" name="updateRecord" value="true"/>
            </div>

            <div id="ofButtons">
                <input type="submit" value="Update Information"/>
                <input type="submit" value="Cancel" onclick="document.forms.ofForm.updateRecord.value = 'false'"/>
            </div>
        </form>

        <?php } //end else ?>
        <div class="clearing"></div>
    </body>
</html>