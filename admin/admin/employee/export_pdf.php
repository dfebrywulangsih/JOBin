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

$pdf = new FPDF();
$pdf->AddPage('L');

$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'List of Employees', 0, 1, 'C');

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(10, 10, 'No.', 1, 0, 'C');
$pdf->Cell(50, 10, 'Name', 1, 0, 'C');
$pdf->Cell(50, 10, 'Address', 1, 0, 'C');
$pdf->Cell(20, 10, 'Sex', 1, 0, 'C');
$pdf->Cell(15, 10, 'Age', 1, 0, 'C');
$pdf->Cell(30, 10, 'Contact No', 1, 0, 'C');
$pdf->Cell(40, 10, 'Position', 1, 1, 'C');

// Query data karyawan
$sql = "SELECT * FROM `tblemployees`";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $count = 0;
    while($row = $result->fetch_assoc()) {
        $count++;
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(10, 10, $count, 1, 0, 'C');
        $pdf->Cell(50, 10, $row['LNAME'] . ', ' . $row['FNAME'], 1, 0, 'L');
        $pdf->Cell(50, 10, $row['ADDRESS'], 1, 0, 'L');
        $pdf->Cell(20, 10, $row['SEX'], 1, 0, 'C');
        $pdf->Cell(15, 10, $row['AGE'], 1, 0, 'C');
        $pdf->Cell(30, 10, $row['TELNO'], 1, 0, 'C');
        $pdf->Cell(40, 10, $row['POSITION'], 1, 1, 'L');
    }
} else {
    echo "0 results";
}
$conn->close();

$pdf->Output();
?>
