<?php
require_once('../components/tcpdf/tcpdf.php');
$conn = mysqli_connect('localhost', 'root', '', 'ku_mess');

// Database connection and query to fetch orders data
// Assuming $orders is an array containing the fetched data from the database

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch orders data
$sql = "SELECT * FROM tbl_orders";
$result = $conn->query($sql);

// Check if there are any rows returned
if ($result->num_rows > 0) {
    // Initialize $orders array
    $orders = array();

    // Fetch each row from the result set
    while($row = $result->fetch_assoc()) {
        // Add each row to the $orders array
        $orders[] = $row;
    }
} else {
    // If no rows returned, set $orders to an empty array
    $orders = array();
}


// // Function to retrieve menu item name from food_id
// function getMenuItemFromFoodId($food_id) {
//     global $conn;
//     $menuItem = '';
    
//     // Query to retrieve menu item name from the food table based on food_id
//     $sql = "SELECT name FROM food WHERE id = $food_id";

//     $result = $conn->query($sql);

//     if ($result->num_rows > 0) {
//         // Fetch menu item name from the result set
//         $row = $result->fetch_assoc();
//         $menuItem = $row['name'];
//     }

//     // Close connection
//     $conn->close();

//     return $menuItem;
// }


// Calculate total revenue
$totalRevenue = 0;
foreach ($orders as $order) {
    $totalRevenue += $order['total'];
}

// // Prepare data for sales by menu item
// $salesByMenuItem = array();
// foreach ($orders as $order) {
//     $menuItem = getMenuItemFromFoodId($order['food_id']); // Function to get menu item name from food_id
//     if (!isset($salesByMenuItem[$menuItem])) {
//         $salesByMenuItem[$menuItem] = array(
//             'quantity' => 0,
//             'revenue' => 0
//         );
//     }
//     $salesByMenuItem[$menuItem]['quantity'] += $order['quantity'];
//     $salesByMenuItem[$menuItem]['revenue'] += $order['total'];
// }

// Create new PDF document
$pdf = new TCPDF();

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Sales Report');
$pdf->SetSubject('Sales Performance');
$pdf->SetKeywords('Sales, Report, Revenue, Menu, Category');

// Add a page
$pdf->AddPage();

// Set font
$pdf->SetFont('helvetica', 'B', 16);

// Add title
$pdf->Cell(0, 10, 'KU Mess - Sales Report', 0, 1, 'C');

// Add Restaurant Logo and Title (Optional)
$logoPath = '../../images/logo.png'; // Replace with your logo path
$pdf->Image($logoPath, 10, 10, 20, 0, '', '', 'T', false, 300, '', false, false, 0, false, false, false);



// Add total revenue
$pdf->Ln(20);
$pdf->SetFont('helvetica', '', 12);
$pdf->Cell(0, 10, 'Total Revenue: Ksh. ' . number_format($totalRevenue, 2), 0, 1);

// Add sales by menu item
// $pdf->Ln(10);
// $pdf->Cell(0, 10, 'Sales by Menu Item:', 0, 1);
// foreach ($salesByMenuItem as $menuItem => $data) {
//     $pdf->Cell(0, 10, $menuItem . ' - Quantity: ' . $data['quantity'] . ', Revenue: $' . number_format($data['revenue'], 2), 0, 1);
// }

// Output PDF to browser
$pdf->Output('sales_report.pdf', 'I');
?>
