<?php

include 'verifyDbLogin.php';
require('includes/fpdf.php');
include 'includes/db_open.php';
session_start();

class PDF extends FPDF {
    function Header() {
        //Add the title on the first page
        if( (isset($_REQUEST['title'])) && ($this->PageNo()==1)) {
            $this->SetFont('Arial', 'B', 18);
            $this->Cell(0, 8, $_REQUEST['title'], 0, 1);
        }

        //Add the column headers
        $this->SetFont('Arial', 'B', 11);
        $header = array('Phone','Name','Email','Address','Major','Birthday','Family','Home City');
        $headerWidth = array(18, 32, 30, 35, 25, 18, 18, 0);
        for($i=0; $i < count($header); $i++)
            $this->Cell($headerWidth[$i], 5, $header[$i], 'B', 0, 'L');
        $this->Ln();
    }

    //Footer for the page number
    function Footer() {
        $this->SetY(-8);
        $this->SetFont('Arial','',8);
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }

}


$pdf = new PDF('P', 'mm', 'Letter');
$pdf->SetMargins(5, 5);
$pdf->SetAutoPageBreak('true', 5);
$pdf->AliasNbPages();
$pdf->AddPage();

$queryStr = $_SESSION['query'];
$result = $database->query($queryStr);
$rows = $result->num_rows;

//Variables
$lineHeight = 5;

//Add the names
$pdf->SetFont('Arial', '', 6);
$entryWidth = array(18, 12, 20, 30, 10, 25, 25, 18, 18, 0);

for($i=0; $i<$rows; $i++) {
    $data = $result->fetch_assoc();
    $phoneNumber = $data['phone'];
	$phoneStr = $phoneNumber;
    if (strlen($phoneStr) == 10) $phoneStr = substr($phoneNumber, 0, 3) . "-" . substr($phoneNumber, 3, 3) . "-" . substr($phoneNumber, 6);
    $pdf->Cell($entryWidth[0], $lineHeight, $phoneStr, 0, 0, 'L');
    $pdf->Cell($entryWidth[1], $lineHeight, $data['first_name'], 0, 0, 'L');
    $pdf->Cell($entryWidth[2], $lineHeight, $data['last_name'], 0, 0, 'L');
    $pdf->Cell($entryWidth[3], $lineHeight, $data['email'], 0, 0, 'L');
    $pdf->Cell($entryWidth[4], $lineHeight, $data['streetNum_local'], 0, 0, 'L');
    $pdf->Cell($entryWidth[5], $lineHeight, $data['street_local'], 0, 0, 'L');
    $pdf->Cell($entryWidth[6], $lineHeight, $data['major'], 0, 0, 'L');
    $pdf->Cell($entryWidth[7], $lineHeight, date('m/d/Y', strtotime($data['birthdate'])), 0, 0, 'L');
    $pdf->Cell($entryWidth[8], $lineHeight, $data['color'], 0, 0, 'L');
    $pdf->Cell($entryWidth[9], $lineHeight, $data['city_perm'] . ', ' . $data['state_perm'], 0, 0, 'L');
    $pdf->Ln();
}

$pdf->Output("Directory.pdf", "D");

?>