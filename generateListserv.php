<?php

include 'verifyDbLogin.php';
include 'includes/db_open.php';
session_start();

$queryStr = "SELECT email, first_name, last_name FROM " . $_SESSION['directoryTable']
    . " WHERE other != 'VTIC Card' AND other != 'VTIC Email' "
    . "AND email != '' "
    . "ORDER BY last_name";
$result = $database->query($queryStr);
$rows = $result->num_rows;

$buffer = "";

for ($i=0; $i < $rows; $i++) {
    $data = $result->fetch_assoc();
    if ($data['email'] != "")
        $buffer .= $data['email'] . "\t" . $data['first_name'] . "\t" . $data['last_name'] . "\r\n";
}

header('Content-Type: application/x-download');
header('Content-Length: '.strlen($buffer));
header('Content-Disposition: attachment; filename="listserv.txt"');
header('Cache-Control: private, max-age=0, must-revalidate');
header('Pragma: public');
echo $buffer;
?>