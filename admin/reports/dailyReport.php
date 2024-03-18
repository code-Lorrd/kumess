<?php
require_once('../components/tcpdf/tcpdf.php');
$conn = mysqli_connect('localhost', 'root', '', 'ku_mess');

// Database connection and query to fetch orders data
// Assuming $orders is an array containing the fetched data from the database

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Determine the time period for the report (e.g., for a specific date)
$now = new DateTime();
$date = $now->format('Y-m-d H:i:s');


// Query to fetch orders data for the specified date
$sql = "SELECT * FROM tbl_orders WHERE YEAR(orderdate) = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $date);
$stmt->execute();
$result = $stmt->get_result();

// Initialize variables for aggregating data
$totalRevenue = 0;
$totalOrders = 0;

// Iterate through orders to calculate total revenue and number of orders
while ($row = $result->fetch_assoc()) {
    $totalRevenue += $row['total'];
    $totalOrders++;
}

// Close statement
$stmt->close();

// Close connection
$conn->close();

// Create new PDF document
$pdf = new TCPDF();

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Daily Summary Report');
$pdf->SetSubject('Summary Report');
$pdf->SetKeywords('Summary, Report, Daily');

// Add a page
$pdf->AddPage();
$logoPath = '../../images/logo.png'; // Replace with your logo path
$pdf->Image($logoPath, 10, 10, 20, 0, '', '', 'T', false, 300, '', false, false, 0, false, false, false);
// Set font
$pdf->SetFont('helvetica', 'B', 16);

// Add title
$pdf->Cell(0, 10, 'Daily Summary Report', 0, 1, 'C');

// Add date
$pdf->Ln(10);
$pdf->SetFont('helvetica', '', 12);
$pdf->Cell(0, 10, 'Date: ' . $date, 0, 1);

// Add summary data
$pdf->Ln(10);
$pdf->Cell(0, 10, 'Total Revenue: $' . number_format($totalRevenue, 2), 0, 1);
$pdf->Cell(0, 10, 'Total Orders: ' . $totalOrders, 0, 1);

// Output PDF to browser
$pdf->Output('daily_summary_report.pdf', 'I');
?>