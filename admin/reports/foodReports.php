<?php
require_once('../components/tcpdf/tcpdf.php');

// Create connection
$conn = mysqli_connect('localhost', 'root', '', 'ku_mess');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch foods from the menu along with their prices
$sql = "SELECT title, price FROM food_items";
$result = $conn->query($sql);

// Create new PDF document
$pdf = new TCPDF();

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Menu with Prices');
$pdf->SetSubject('Menu');
$pdf->SetKeywords('Menu, Prices');

// Add a page
$pdf->AddPage();
$logoPath = '../../images/logo.png'; // Replace with your logo path
$pdf->Image($logoPath, 10, 10, 20, 0, '', '', 'T', false, 300, '', false, false, 0, false, false, false);
// Set font
$pdf->SetFont('helvetica', '', 12);

// Add title
$pdf->Cell(0, 10, 'Menu with Prices', 0, 1, 'C');
$pdf->Cell(20,10, '', 0, 1);

// Check if there are any rows returned
if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        $pdf->Cell(0, 10, 'Food: ' . $row["title"]. ' -------------------------------------------------------------------------- Ksh. ' . $row["price"], 0, 1);
    }
} else {
    $pdf->Cell(0, 10, 'No menu items found.', 0, 1);
}

// Close connection
$conn->close();

// Output PDF to browser
$pdf->Output('menu_with_prices.pdf', 'I');
?>
