<?php
require_once('components/tcpdf/tcpdf.php');

// Create connection
$conn = mysqli_connect('localhost', 'root', '', 'ku_mess');

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Query to fetch all orders (replace with specific columns if needed)
$sql = "SELECT * FROM tbl_orders ORDER BY id DESC";
$result = $conn->query($sql);

// Create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, 'mm', PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Restaurant Order Report');
$pdf->SetSubject('Orders');
$pdf->SetKeywords('Restaurant, Orders');

// Start a new page
$pdf->AddPage();

// Optional: Include logo
$logoPath = '../../images/logo.png'; // Replace with your logo path
if (file_exists($logoPath)) {
  $pdf->Image($logoPath, 10, 10, 20, 0, '', '', 'T', false, 300, '', false, false, 0, false, false, false);
}

// Set font
$pdf->SetFont('helvetica', '', 8);

// Add title (modify as needed)
$pdf->Cell(0, 10, 'Restaurant Name - Order Report', 0, 1, 'C');

// Check if any orders were found
if ($result->num_rows > 0) {
  // Create table header row
  $pdf->Cell(10, 7, 'S.N', 1, 0, 'C');
  $pdf->Cell(14, 7, 'Food', 1, 0, 'C');
  $pdf->Cell(20, 7, 'Price', 1, 0, 'C');
  $pdf->Cell(15, 7, 'Quantity', 1, 0, 'C');
  $pdf->Cell(20, 7, 'Total', 1, 0, 'C');
  $pdf->Cell(30, 7, 'Date', 1, 0, 'C');
  $pdf->Cell(15, 7, 'Status', 1, 0, 'C');
  $pdf->Cell(27, 7, 'Customer Name', 1, 0, 'C');
  $pdf->Cell(20, 7, 'Contact', 1, 0, 'C');
  // $pdf->Cell(30, 7, 'Email', 1, 0, 'C');
  $pdf->Cell(0, 7, 'Address', 1, 1, 'C');

  // Loop through each order and display details
  $sn = 1;
  while ($row = $result->fetch_assoc()) {
    $id = $row['id'];
    $food = $row['food_id'];
    $price = $row['price'];
    $quantity = $row['quantity'];
    $total = $row['total'];
    $orderdate = $row['orderdate'];
    $status = $row['status'];
    $customername = $row['customername'];
    $customercontact = $row['customercontact'];
    $customeremail = $row['customeremail'];
    $customeraddress = $row['customeraddress'];

    // Query to fetch food name based on ID (optional)
    if (!empty($food)) {
      $sql2 = "SELECT title FROM food_items WHERE id='$food'";
      $res2 = $conn->query($sql2);
      if ($res2->num_rows > 0) {
        $row2 = $res2->fetch_assoc();
        $foodname = $row2['title'];
      } else {
        $foodname = 'Food Not Found'; // Handle missing food data
      }
    } else {
      $foodname = ''; // Handle missing food ID
    }

    // Display order details in each row
    $pdf->Cell(10, 7, $sn++, 1, 0, 'C');
    $pdf->Cell(14, 7, $foodname, 1, 0, 'L');
    $pdf->Cell(20, 7, $price, 1, 0, 'C');
    $pdf->Cell(15, 7, $quantity, 1, 0, 'C');
    $pdf->Cell(20, 7, $total, 1, 0, 'C');
    $pdf->Cell(30, 7, $orderdate, 1, 0, 'C');
    $pdf->Cell(15, 7, $status, 1, 0, 'C');
    $pdf->Cell(27, 7, $customername, 1, 0, 'L');
    $pdf->Cell(20, 7, $customercontact, 1, 0, 'C');
    // $pdf->Cell(30, 7, $customeremail, 1, 0, 'L');
    $pdf->MultiCell(0, 7, $customeraddress, 1, 'L');  // Use MultiCell for wrapping address
  }
} else {
  // Display message if no orders found
  $pdf->Cell(0, 10, 'No orders found in the database.', 0, 1, 'C');
}

// Close connection
$conn->close();

// Output PDF to browser
$pdf->Output('order_report.pdf', 'I');
?>
