<?php
include 'verifyDbLogin.php';
require('includes/PDF_Label.php');
include 'includes/db_open.php';
session_start();


$queryStr = "SELECT * FROM " . $_SESSION['directoryTable'] . " ORDER BY zip_perm, last_name";
$result = $database->query($queryStr);
$rows = $result->num_rows;

$pdf = new PDF_Label('5160');
$pdf->Open();
$pdf->SetFontSize(11);
$pdf->AddPage();

// Print labels
for($i=0; $i<$rows; $i++) {
    $data = $result->fetch_assoc();
    if ( !empty($data['zip_perm']) && !empty($data['street_perm']) ) {
	    if (isset($_REQUEST['topLine'])) {
	        $pdf->Add_Label(sprintf("%s\n%s %s\n%s\n%s, %s  %s",
	                $_REQUEST['topLine'],
	                $data['first_name'], $data['last_name'],
	                $data['street_perm'],
	                $data['city_perm'], $data['state_perm'], $data['zip_perm']));
	    } else {
	        $pdf->Add_Label(sprintf("%s %s\n%s\n%s %s, %s",
	            $data['first_name'], $data['last_name'],
	            $data['street_perm'],
	            $data['city_perm'], $data['state_perm'], $data['zip_perm']));
            }
    }
}

$pdf->Output("MailingLabels.pdf", "D");
?>