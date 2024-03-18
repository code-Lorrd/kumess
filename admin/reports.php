<?php
include 'components/menu.php';

function getOrdersByDate($startDate, $endDate) {
    global $conn;
    $sql = "SELECT * FROM tbl_orders WHERE orderdate BETWEEN '$startDate' AND '$endDate'";
    $result = mysqli_query($conn, $sql);
    $report_data = array();
    if (mysqli_num_rows($result) > 0) {
      while($row = mysqli_fetch_assoc($result)) {
        $report_data[] = $row;
      }
    }
    return $report_data;
  }
  
  
  // Include TCPDF library (replace with mPDF if using)
  ob_start(); // Start output buffering
  require_once('components/tcpdf/tcpdf.php');
  // Create new PDF document
$pdf = new TCPDF();

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Sample PDF');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// Add a page
$pdf->AddPage();

// Set font
$pdf->SetFont('helvetica', 'B', 16);

// Add content
$pdf->Cell(0, 10, 'Hello, World!', 0, 1, 'C');

// Output PDF to browser
$pdf->Output('example.pdf', 'I');

ob_end_flush(); // Flush the output buffer
?>