<?php

include 'verifyDbLogin.php';
require('includes/fpdf.php');
include 'includes/db_open.php';
include 'includes/dates.php';
session_start();

class PDF extends FPDF {
    function Header() {
        //Add the title on the first page
        if($this->PageNo()==1) {
            $title = ucwords($_REQUEST['color']) . ' Family - ' . ucwords($_REQUEST['sem']) . ' Semester';
            $this->SetFont('Arial', 'B', 18);
            $this->Cell(0, 8, $title, 0, 1);
        }

        //Add the column headers
        $this->SetFont('Arial', 'B', 10);
        
        //Allow access to global variable weeks in dates.php, included above
        global $weeks;
        $header = array('Name', date("n/j", $weeks[0]), date("n/j", $weeks[1]), date("n/j", $weeks[2]),
            date("n/j", $weeks[3]), date("n/j", $weeks[4]), date("n/j", $weeks[5]), date("n/j", $weeks[6]),
            date("n/j", $weeks[7]), date("n/j", $weeks[8]), date("n/j", $weeks[9]), date("n/j", $weeks[10]),
            date("n/j", $weeks[11]), date("n/j", $weeks[12]), date("n/j", $weeks[13]), date("n/j", $weeks[14]));
        $headerWidth = array(32, 11, 11, 11, 11, 11, 11, 11, 11, 11, 11, 11, 11, 11, 11, 11);

        for($i=0; $i < count($header); $i++)
            $this->Cell($headerWidth[$i], 5, $header[$i], 1, 0, 'C');
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

$queryStr = "SELECT * FROM " . $_SESSION['directoryTable'] . ", " . $_SESSION['directoryAttTable'] . " WHERE color='" . $_REQUEST['color'] . "' ";
$queryStr .= "AND " . $_SESSION['directoryAttTable'] . ".studentID = " . $_SESSION['directoryTable'] . ".id ";
$queryStr .= "ORDER BY last_name, first_name";
$result = $database->query($queryStr);
$rows = $result->numRows();

//Variables
$lineHeight = 5;

//Add the names
$pdf->SetFont('Arial', '', 6);
$entryWidth = array(12, 20, 11, 11, 11, 11, 11, 11, 11, 11, 11, 11, 11, 11, 11, 11, 11);

for($i=0; $i<$rows; $i++) {
    $data = $result->fetchRow(DB_FETCHMODE_ASSOC, $i);
    $pdf->Cell($entryWidth[0], $lineHeight, $data['first_name'], 'LB', 0, 'L');
    $pdf->Cell($entryWidth[1], $lineHeight, $data['last_name'], 'BR', 0, 'L');
    for ($j = 1; $j <= 15; $j++) {
        if ($_REQUEST['sem'] == 'spring') $varName = "week" . ($j + 15);
        else $varName = "week" . $j;
        $contents = ($data[$varName] == '1') ? 'X' : '';
        $pdf->Cell($entryWidth[$j + 1], $lineHeight, $contents, 1, 0, 'C');
    }
    $pdf->Ln();
}

$pdf->Output("Directory.pdf", "D");

?>