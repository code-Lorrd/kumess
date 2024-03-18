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


// Initialize arrays to store quantity and revenue data for each food item
$foodQuantity = [];
$foodRevenue = [];

// Iterate through orders to calculate quantity and revenue for each food item
foreach ($orders as $order) {
    $foodId = $order['food_id'];
    $quantity = $order['quantity'];
    $total = $order['total'];
    
    // Increment total quantity for the food item
    if (!isset($foodQuantity[$foodId])) {
        $foodQuantity[$foodId] = 0;
    }
    $foodQuantity[$foodId] += $quantity;

    // Increment total revenue for the food item
    if (!isset($foodRevenue[$foodId])) {
        $foodRevenue[$foodId] = 0;
    }
    $foodRevenue[$foodId] += $total;
}

// Find the most and least ordered food items
arsort($foodQuantity); // Sort food items by quantity in descending order
$mostOrderedFoodItem = key($foodQuantity); // Get the food ID of the most ordered item
$leastOrderedFoodItem = array_key_last($foodQuantity); // Get the food ID of the least ordered item

// Query to search for the food name using the food_id
$sql = "SELECT title FROM food_items WHERE id = '$mostOrderedFoodItem'";

// Prepare the statement
$stmt = $conn->prepare($sql);
// Execute the statement
$stmt->execute();

// Bind result variables
$stmt->bind_result($mostOrderedFoodName);

// Fetch the result
$stmt->fetch();

// Close statement
$stmt->close();

// Query to search for the food name using the food_id
$sql = "SELECT title FROM food_items WHERE id = '$leastOrderedFoodItem'";

// Prepare the statement
$stmt = $conn->prepare($sql);

// Execute the statement
$stmt->execute();

// Bind result variables
$stmt->bind_result($leastOrderedFoodName);

// Fetch the result
$stmt->fetch();

// Close statement
$stmt->close();

// Close connection
$conn->close();

// Create new PDF document
$pdf = new TCPDF();

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Menu Performance Report');
$pdf->SetSubject('Menu Performance');
$pdf->SetKeywords('Menu, Performance, Revenue');

// Add a page
$pdf->AddPage();

// Add Restaurant Logo and Title (Optional)
$logoPath = '../../images/logo.png'; // Replace with your logo path
$pdf->Image($logoPath, 10, 10, 20, 0, '', '', 'T', false, 300, '', false, false, 0, false, false, false);


// Set font
$pdf->SetFont('helvetica', 'B', 16);

// Add title
$pdf->Cell(0, 10, 'Menu Performance Report', 0, 1, 'C');

// Add most ordered food item
$pdf->Ln(10);
$pdf->SetFont('helvetica', '', 12);
$pdf->Cell(0, 10, 'Most Ordered Food Item:', 0, 1);
$pdf->Cell(0, 10, 'Food: ' . $mostOrderedFoodName . ', Quantity: ' . $foodQuantity[$mostOrderedFoodItem] . ', Revenue: Ksh. ' . number_format($foodRevenue[$mostOrderedFoodItem], 2), 0, 1);

// Add least ordered food item
$pdf->Ln(10);
$pdf->Cell(0, 10, 'Least Ordered Food Item:', 0, 1);
$pdf->Cell(0, 10, 'Food: ' . $leastOrderedFoodName . ', Quantity: ' . $foodQuantity[$leastOrderedFoodItem] . ', Revenue: Ksh. ' . number_format($foodRevenue[$leastOrderedFoodItem], 2), 0, 1);

// Output PDF to browser
$pdf->Output('menu_performance_report.pdf', 'I');


?>
