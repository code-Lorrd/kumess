<?php
require_once('../components/tcpdf/tcpdf.php');
$conn = mysqli_connect('localhost', 'root', '', 'ku_mess');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch historical sales data from the orders table
$sql = "SELECT SUM(total) AS total_sales, MONTH(orderdate) AS month, YEAR(orderdate) AS year FROM tbl_orders GROUP BY YEAR(orderdate), MONTH(orderdate) ORDER BY year, month";
$result = $conn->query($sql);

// Store historical sales data
$historicalSales = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $historicalSales[] = $row['total_sales'];
    }
}

// Close connection
$conn->close();

// Calculate average monthly sales
$averageMonthlySales = array_sum($historicalSales) / count($historicalSales);

// Define number of months for forecasting
$forecastingMonths = 12; // Forecasting for the next 12 months

// Extrapolate future sales based on average monthly sales
$forecastedSales = [];
$currentMonthSales = end($historicalSales);
for ($i = 0; $i < $forecastingMonths; $i++) {
    $forecastedSales[] = $currentMonthSales + $averageMonthlySales;
    $currentMonthSales = end($forecastedSales);
}

// Create new PDF document
$pdf = new TCPDF();

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Forecasting and Budgeting Report');
$pdf->SetSubject('Sales Forecast');
$pdf->SetKeywords('Forecast, Budget, Sales');

// Add a page
$pdf->AddPage();
$logoPath = '../../images/logo.png'; // Replace with your logo path
$pdf->Image($logoPath, 10, 10, 20, 0, '', '', 'T', false, 300, '', false, false, 0, false, false, false);
// Set font
$pdf->SetFont('helvetica', '', 12);

// Add title
$pdf->Cell(0, 10, 'Forecasting and Budgeting Report', 0, 1, 'C');

// Add forecasted sales data
$pdf->Ln(10);
$pdf->Cell(0, 10, 'Forecasted Sales for the Next ' . $forecastingMonths . ' Months:', 0, 1);
foreach ($forecastedSales as $month => $sales) {
    $pdf->Cell(0, 10, 'Month ' . ($month + 1) . ': Ksh. ' . number_format($sales, 2), 0, 1);
}

// Output PDF to browser
$pdf->Output('forecasting_and_budgeting_report.pdf', 'I');
?>
