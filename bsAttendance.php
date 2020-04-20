<?php
include 'verifyDbLogin.php';
include 'includes/db_open.php';
include 'includes/dates.php';

session_start();

    $color = 'blue';
    $sem = 'fall';
    $week = '0';

    if (isset($_REQUEST['formAction'])) {
        $color = $_REQUEST['color'];
        $sem = $_REQUEST['sem'];
        $week = $_REQUEST['week'];
        if ($_REQUEST['formAction'] == 'updateAtt' && $week != '0') {
            $studentsQuery = "SELECT * FROM " . $_SESSION['directoryTable'] . " WHERE color='" . $color . "'";
            $studentsResult = $database->query($studentsQuery);
            $studentsRows = $studentsResult->num_rows;
            
            for ($i=0; $i<$studentsRows; $i++) {
                $data = $studentsResult->fetch_assoc();
                $id = $data['id'];
                $varName = ($sem == 'spring') ? "week" . ($week + 15) : "week" . $week;
                if (isset($_REQUEST[$id]))
                    $updateQuery = "UPDATE " . $_SESSION['directoryAttTable'] . " SET $varName = '1' WHERE studentID = '$id'";
                else
                    $updateQuery = "UPDATE " . $_SESSION['directoryAttTable'] . " SET $varName = '0' WHERE studentID = '$id'";
                
                $database->query($updateQuery);
                $database->commit();
            }

            $week = 0; //Reset so that we're not editing anymore after the update
        }
    }

    $queryStr = "SELECT * FROM " . $_SESSION['directoryTable'] . ", " . $_SESSION['directoryAttTable'] . " WHERE color='" . $color . "' ";
    $queryStr .= "AND " . $_SESSION['directoryAttTable'] . ".studentID = " . $_SESSION['directoryTable'] . ".id ";
    $queryStr .= "ORDER BY last_name, first_name";

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
        </script>
    </head>
    <body>
        <h3><?php echo $_REQUEST['color']?> Family Attendance</h3>
        <form name="attendance_select_form" method="post" action="bsAttendance.php">
            <input type="hidden" name="formAction" id="formAction" value="updateTime"/>
            <div id="family">
                Family:&nbsp;
                <select name="color">
                    <option value="blue" <?php if ($color == 'blue') echo "selected";?>>Blue</option>
                    <option value="brown" <?php if ($color == 'brown') echo "selected";?>>Brown</option>
                    <option value="gold" <?php if ($color == 'gold') echo "selected";?>>Gold</option>
                    <option value="green" <?php if ($color == 'green') echo "selected";?>>Green</option>
                    <option value="maroon" <?php if ($color == 'maroon') echo "selected";?>>Maroon</option>
                    <option value="navy" <?php if ($color == 'navy') echo "selected";?>>Navy</option>
                    <option value="orange" <?php if ($color == 'orange') echo "selected";?>>Orange</option>
                    <option value="pink" <?php if ($color == 'pink') echo "selected";?>>Pink</option>
                    <option value="purple" <?php if ($color == 'purple') echo "selected";?>>Purple</option>
                    <option value="red" <?php if ($color == 'red') echo "selected";?>>Red</option>
                    <option value="silver" <?php if ($color == 'silver') echo "selected";?>>Silver</option>
                    <option value="yellow" <?php if ($color == 'yellow') echo "selected";?>>Yellow</option>
                </select>
            </div>
            <div id="semester">
                Semester:&nbsp;
                <select name="sem">
                    <option value="fall" <?php if ($sem == 'fall') echo "selected";?>>Fall</option>
                    <option value="spring" <?php if ($sem == 'spring') echo "selected";?>>Spring</option>
                </select>
            </div>
            <div id="week">
                Week to Edit:&nbsp;
                <select name="week">
                    <option value="0" <?php if ($week == '0') echo "selected";?>>-</option>
                    <option value="1" <?php if ($week == '1') echo "selected";?>>1 (<?php echo date("m/d/y", $weeks[0]);?>)</option>
                    <option value="2" <?php if ($week == '2') echo "selected";?>>2 (<?php echo date("m/d/y", $weeks[1]);?>)</option>
                    <option value="3" <?php if ($week == '3') echo "selected";?>>3 (<?php echo date("m/d/y", $weeks[2]);?>)</option>
                    <option value="4" <?php if ($week == '4') echo "selected";?>>4 (<?php echo date("m/d/y", $weeks[3]);?>)</option>
                    <option value="5" <?php if ($week == '5') echo "selected";?>>5 (<?php echo date("m/d/y", $weeks[4]);?>)</option>
                    <option value="6" <?php if ($week == '6') echo "selected";?>>6 (<?php echo date("m/d/y", $weeks[5]);?>)</option>
                    <option value="7" <?php if ($week == '7') echo "selected";?>>7 (<?php echo date("m/d/y", $weeks[6]);?>)</option>
                    <option value="8" <?php if ($week == '8') echo "selected";?>>8 (<?php echo date("m/d/y", $weeks[7]);?>)</option>
                    <option value="9" <?php if ($week == '9') echo "selected";?>>9 (<?php echo date("m/d/y", $weeks[8]);?>)</option>
                    <option value="10" <?php if ($week == '10') echo "selected";?>>10 (<?php echo date("m/d/y", $weeks[9]);?>)</option>
                    <option value="11" <?php if ($week == '11') echo "selected";?>>11 (<?php echo date("m/d/y", $weeks[10]);?>)</option>
                    <option value="12" <?php if ($week == '12') echo "selected";?>>12 (<?php echo date("m/d/y", $weeks[11]);?>)</option>
                    <option value="13" <?php if ($week == '13') echo "selected";?>>13 (<?php echo date("m/d/y", $weeks[12]);?>)</option>
                    <option value="14" <?php if ($week == '14') echo "selected";?>>14 (<?php echo date("m/d/y", $weeks[13]);?>)</option>
                    <option value="15" <?php if ($week == '15') echo "selected";?>>15 (<?php echo date("m/d/y", $weeks[14]);?>)</option>
                </select>
            </div>
            <input type="submit" value="Select"/>
            <?php
                $linkUrl = "generateBsList.php";
                $linkUrl .= "?color=" . $color . "&sem=" . $sem;
            ?>
            <br/><a href="<?php echo $linkUrl;?>">Print Attendance Sheet</a>
        </form>

        <form name="attendance_update_form" method="post" action="bsAttendance.php">
            <input type="hidden" name="color" value="<?php echo $color; ?>"/>
            <input type="hidden" name="sem" value="<?php echo $sem; ?>"/>
            <input type="hidden" name="week" value="<?php echo $week; ?>"/>
            <input type="hidden" name="formAction" id="formAction" value="updateAtt"/>
        <div id="dirNoLink">
            <table>
                <tr>
                    <th colspan="2">Name</th>
                    <th colspan="15">Week of <?php echo ($sem == 'spring') ? 'Spring' : 'Fall'; ?> Semester</th>
                </tr>
                <tr>
                    <th>First</th>
                    <th>Last</th>
                    <?php for ($i = 0; $i < 15; $i++) {
                        echo "<th>". date("n/j", $weeks[$i]) ."</th>";
                    } ?>
                </tr>
            <?php
                $males = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
                $females = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
                for ($i=0; $i < $rows; $i++) {
                    $data = $result->fetch_assoc();
                    if ($i % 2 == 1) echo "<tr class='shaded'>";
                    else echo "<tr>";
                    echo "<td>" . $data['first_name'] . "</td>";
                    echo "<td>" . $data['last_name'] . "</td>";
                    for ($j = 1; $j <= 15; $j++) {
                        echo "<td>";
                        if ($sem == 'spring') $varName = "week" . ($j + 15);
                        else $varName = "week" . $j;
                        if ($j == $week) {
                            if ($data[$varName] == '1') {
                                echo "<input type='checkbox' name='$data[id]' checked='yes'/>";
                                if ($data['gender'] == "m") $males[$j - 1]++;
                                else $females[$j - 1]++;
                            } else {
                                echo "<input type='checkbox' name='$data[id]'/>";
                            }
                        } else if ($data[$varName] == '1') {
                            echo 'x';
                            if ($data['gender'] == "m") $males[$j - 1]++;
                            else $females[$j - 1]++;
                        }
                        echo "</td>";
                    }
                }
            ?>
                <tr>
                    <td colspan="2">Males:</td>
                    <?php for ($i=0; $i < 15; $i++) echo "<td>$males[$i]</td>"; ?>
                </tr>
                <tr>
                    <td colspan="2">Females:</td>
                    <?php for ($i=0; $i < 15; $i++) echo "<td>$females[$i]</td>"; ?>
                </tr>
                <tr>
                    <td colspan="2">Total:</td>
                    <?php for ($i=0; $i < 15; $i++) echo "<td>" . ($males[$i]+$females[$i]) . "</td>"; ?>
                </tr>
            </table>
        </div>
            <?php if ($week != 0) echo "<input type='submit' value='Update Attendance'/>";?>
        </form>
        <div class="clearing"></div>
    </body>
</html>
