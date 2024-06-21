<?php
require('fpdf/fpdf.php');

defined('server') ? null : define("server", "localhost");
defined('user') ? null : define ("user", "root");
defined('pass') ? null : define("pass","");
defined('database_name') ? null : define("database_name", "jobindb");

$this_file = str_replace('\\', '/', __FILE__);
$doc_root = $_SERVER['DOCUMENT_ROOT'];

$web_root = str_replace(array($doc_root, "include/config.php"), '', $this_file);
$server_root = str_replace('config/config.php', '', $this_file);


// Create connection
$conn = new mysqli(server, user, pass, database_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Extend FPDF class to create a custom header and footer
class PDF extends FPDF
{
    // Page header
    function Header()
    {
        // Title
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'List of Applicants', 0, 1, 'C');
        $this->Ln(5);

        // Column headers
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(30, 10, 'Applicant', 1, 0, 'C');
        $this->Cell(40, 10, 'Job Title', 1, 0, 'C');
        $this->Cell(40, 10, 'Company', 1, 0, 'C');
        $this->Cell(30, 10, 'Applied Date', 1, 0, 'C');
        $this->Cell(50, 10, 'Remarks', 1, 0, 'C');
        $this->Ln();
    }

    // Page footer
    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}

// Create new PDF object
$pdf = new PDF();
$pdf->AliasNbPages(); // Enable page numbering

// Add a page
$pdf->AddPage();

// Set font
$pdf->SetFont('Arial', '', 10);

// Retrieve data from database

$sql = "SELECT * FROM `tblcompany` c, `tbljobregistration` j, `tbljob` j2, `tblapplicants` a WHERE c.`COMPANYID`=j.`COMPANYID` AND j.`JOBID`=j2.`JOBID` AND j.`APPLICANTID`=a.`APPLICANTID`";
$result = $conn->query($sql);
// $cur = $koneksi->loadResultList();

// Iterate through data and add rows to PDF
foreach ($conn as $result) {
    $pdf->Cell(30, 10, $result->APPLICANT, 1, 0, 'L');
    $pdf->Cell(40, 10, $result->OCCUPATIONTITLE, 1, 0, 'L');
    $pdf->Cell(40, 10, $result->COMPANYNAME, 1, 0, 'L');
    $pdf->Cell(30, 10, $result->REGISTRATIONDATE, 1, 0, 'L');
    $pdf->Cell(50, 10, $result->REMARKS, 1, 0, 'L');
    $pdf->Ln();
}

// Output PDF
$pdf->Output('applicants.pdf', 'D'); // 'D' untuk download, 'I' untuk tampilan inline, 'F' untuk menyimpan ke file

?>
