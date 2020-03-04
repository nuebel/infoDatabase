<?php
include 'verifyDbLogin.php';
include 'includes/db_open.php';
session_start();

    //On Campus Queries
    $queryStr = "SELECT * FROM " . $_SESSION['directoryTable'] . " WHERE on_campus='true'";
    $result = $database->query($queryStr);
    $numOnCampus = $result->num_rows;

    $queryStr = "SELECT * FROM " . $_SESSION['directoryTable'] . " WHERE on_campus='true'";
    $queryStr .= " AND gender='m'";
    $result = $database->query($queryStr);
    $numOnCampusMale = $result->num_rows;

    $queryStr = "SELECT * FROM " . $_SESSION['directoryTable'] . " WHERE on_campus='true'";
    $queryStr .= " AND gender='f'";
    $result = $database->query($queryStr);
    $numOnCampusFemale = $result->num_rows;

    $queryStr = "SELECT COUNT(*) AS count, street_local FROM " . $_SESSION['directoryTable'];
    $queryStr .= " WHERE on_campus='true'";
    $queryStr .= " GROUP BY street_local ORDER BY street_local";
    $dormResult = $database->query($queryStr);

    //All Student Queries
    $queryStr = "SELECT * FROM " . $_SESSION['directoryTable'];
    $result = $database->query($queryStr);
    $numAll = $result->num_rows;

    $queryStr = "SELECT * FROM " . $_SESSION['directoryTable'] . " WHERE gender='m'";
    $result = $database->query($queryStr);
    $numAllMale = $result->num_rows;

    $queryStr = "SELECT * FROM " . $_SESSION['directoryTable'] . " WHERE gender='f'";
    $result = $database->query($queryStr);
    $numAllFemale = $result->num_rows;

    $queryStr = "SELECT COUNT(*) AS count, class FROM " . $_SESSION['directoryTable'];
    $queryStr .= " GROUP BY class ORDER BY class";
    $classResult = $database->query($queryStr);

    //Bible Study Queries
    for ($i=1; $i<=30; $i++) {
        $queryStr = "SELECT * FROM " . $_SESSION['directoryAttTable'] . " WHERE week" . $i . "='1'";
        $result = $database->query($queryStr);
        $bs_all[$i] = $result->num_rows;

        $queryStr = "SELECT * FROM " . $_SESSION['directoryTable'] . ", " . $_SESSION['directoryAttTable']
            . " WHERE " . $_SESSION['directoryAttTable'] . ".studentID = " . $_SESSION['directoryTable'] . ".id "
            . " AND " . $_SESSION['directoryTable'] . ".gender='m' "
            . " AND " . $_SESSION['directoryAttTable'] . ".week" . $i . "='1'";
        $result = $database->query($queryStr);
        $bs_male[$i] = $result->num_rows;

        $bs_female[$i] = $bs_all[$i] - $bs_male[$i];
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
        <h3>Statistics</h3>
        <div id="directory">
            <div id="on_campus_stats">
            <h4>On Campus Students</h4>
            <table>
                <tr onclick="DoNav('dbSearch.php?onCampus=true');"><td>Total Number</td><td><?php echo $numOnCampus;?></td></tr>
                <tr onclick="DoNav('dbSearch.php?onCampus_gender=m');"><td>Males</td><td><?php echo $numOnCampusMale;?></td></tr>
                <tr onclick="DoNav('dbSearch.php?onCampus_gender=f');"><td>Females</td><td><?php echo $numOnCampusFemale;?></td></tr>
                <?php
                $rows = $dormResult->num_rows;
                for ($i=0; $i < $rows; $i++) {
                    $data = $dormResult->fetch_assoc();
                    echo "<tr onclick=\"DoNav('dbSearch.php?dorm=" . $data['street_local'] . "');\">";
                    echo "<td>" . $data['street_local'] . "</td><td>" . $data['count'] . "</td></tr>";
                }
                ?>
            </table>
            </div>

            <div id="all_stats">
                <h4>All Students</h4>
                <table>
                    <tr onclick="DoNav('dbSearch.php');"><td>Total Number</td><td><?php echo $numAll;?></td></tr>
                    <tr onclick="DoNav('dbSearch.php?gender=m');"><td>Males</td><td><?php echo $numAllMale;?></td></tr>
                    <tr onclick="DoNav('dbSearch.php?gender=f');"><td>Females</td><td><?php echo $numAllFemale;?></td></tr>
                <?php
                    $rows = $classResult->num_rows;
                    for ($i=0; $i < $rows; $i++) {
                        $data = $classResult->fetch_assoc();
                        echo "<tr onclick=\"DoNav('dbSearch.php?class=" . $data['class'] . "');\">";
                        echo "<td>Class: " . $data['class'] . "</td><td>" . $data['count'] . "</td></tr>";
                    }
                ?>
                </table>
            </div>

            <div id="bs_stats">
                <h4>Bible Studies</h4>
                <table>
                    <tr><th>Week</th><th>Total</th><th>Avg</th><th>Males</th><th>Avg</th><th>Females</th><th>Avg</th></tr>
                    <?php
                        $count = 30;
                        for ($i=1; $i<=30; $i++) {
                            echo "<tr><td>$i</td><td>" . $bs_all[$i] . "</td><td>" . round($bs_all[$i]/10, 1) . "</td>";
                            echo "<td>" . $bs_male[$i] . "</td><td>" . round($bs_male[$i]/10, 1) . "</td>";
                            echo "<td>" . $bs_female[$i] . "</td><td>" . round($bs_female[$i]/10, 1) . "</td></tr>";
                            if ($bs_all[$i] == 0) $count--;
                        }
                        echo "<tr><th>Avg</th><th>" . round(array_sum($bs_all)/$count, 1) . "</th><th>" . round(array_sum($bs_all)/($count*10), 1) . "</th>";
                        echo "<th>" . round(array_sum($bs_male)/$count, 1) . "</th><th>" . round(array_sum($bs_male)/($count*10), 1) . "</th>";
                        echo "<th>" . round(array_sum($bs_female)/$count, 1) . "</th><th>" . round(array_sum($bs_female)/($count*10), 1) . "</th></tr>";
                    ?>

                </table>
            </div>
        </div>

        <div class="clearing"></div>
    </body>
</html>