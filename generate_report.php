<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require('fpdf186/fpdf.php');
include 'connect.php';

// Simplified NbLines function without accessing protected properties
function NbLines($pdf, $w, $txt) {
    // Approximate max width by subtracting small margin (3 mm)
    $maxWidth = $w - 3;

    $lines = 0;
    $words = explode(' ', $txt);
    $currentLine = '';

    foreach ($words as $word) {
        $testLine = $currentLine ? $currentLine . ' ' . $word : $word;
        $testWidth = $pdf->GetStringWidth($testLine);
        if ($testWidth > $maxWidth) {
            $lines++;
            $currentLine = $word;
        } else {
            $currentLine = $testLine;
        }
    }
    if ($currentLine) {
        $lines++;
    }
    return $lines;
}

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

// Title
$pdf->Cell(0, 10, 'Blissful Bites Report', 0, 1, 'C');
$pdf->Ln(5);

///////////////////////
// --- USERS SECTION
///////////////////////
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'Users', 0, 1);
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetFillColor(255, 182, 193); // Light pink

// User columns widths
$user_w = [10, 25, 25, 40, 50, 20];

$pdf->Cell($user_w[0], 10, 'ID', 1, 0, 'C', true);
$pdf->Cell($user_w[1], 10, 'First Name', 1, 0, 'C', true);
$pdf->Cell($user_w[2], 10, 'Last Name', 1, 0, 'C', true);
$pdf->Cell($user_w[3], 10, 'Company', 1, 0, 'C', true);
$pdf->Cell($user_w[4], 10, 'Email', 1, 0, 'C', true);
$pdf->Cell($user_w[5], 10, 'Verified', 1, 1, 'C', true);

$pdf->SetFont('Arial', '', 12);
$userResult = $conn->query("SELECT id, first_name, last_name, company_name, email, email_verified FROM users");

if ($userResult && $userResult->num_rows > 0) {
    while ($row = $userResult->fetch_assoc()) {
        $pdf->Cell($user_w[0], 8, $row['id'], 1);
        $pdf->Cell($user_w[1], 8, $row['first_name'], 1);
        $pdf->Cell($user_w[2], 8, $row['last_name'], 1);
        $pdf->Cell($user_w[3], 8, $row['company_name'], 1);
        $pdf->Cell($user_w[4], 8, $row['email'], 1);
        $pdf->Cell($user_w[5], 8, $row['email_verified'] ? 'Yes' : 'No', 1, 1, 'C');
    }
} else {
    $pdf->Cell(array_sum($user_w), 8, "No users found.", 1, 1, 'C');
}

$pdf->Ln(10);

////////////////////////
// --- ORDERS SECTION
////////////////////////
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'Orders', 0, 1);
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetFillColor(255, 182, 193); // Light pink

// Order columns widths
$order_w = [30, 55, 50, 20, 20, 20];
$order_header = ['Customer Name', 'Address', 'Items', 'Total (₱)', 'Payment', 'Status'];

// Header row
for ($i = 0; $i < count($order_header); $i++) {
    $pdf->Cell($order_w[$i], 10, $order_header[$i], 1, 0, 'C', true);
}
$pdf->Ln();

$pdf->SetFont('Arial', '', 11);

// Load product names from menu.xml (optional, for validation)
$products = [];
$xmlFile = 'menu.xml';
if (file_exists($xmlFile)) {
    $xml = simplexml_load_file($xmlFile);
    foreach ($xml->pastry as $p) {
        $name = (string)$p->name;
        $products[$name] = $name;
    }
}

$orderQuery = $conn->query("SELECT * FROM orders");

if ($orderQuery && $orderQuery->num_rows > 0) {
    while ($order = $orderQuery->fetch_assoc()) {
        $customerName = $order['first_name'] . ' ' . $order['last_name'];
        $address = trim($order['company_name'] . ', ' . $order['street'] . ', ' . $order['city'] . ', ' . $order['province'], ', ');

        $items = json_decode($order['cart_data'], true);
        $itemList = [];

        if (is_array($items)) {
            foreach ($items as $item) {
                $name = $item['name'] ?? 'Unknown';
                $qty = $item['quantity'] ?? 1;
                $itemList[] = "$name ($qty)";
            }
        } else {
            $itemList[] = "No items";
        }

        $itemsStr = implode(", ", $itemList);

        // Calculate max lines for multiline cells
        $addressLines = NbLines($pdf, $order_w[1], $address);
        $itemsLines = NbLines($pdf, $order_w[2], $itemsStr);
        $maxLines = max($addressLines, $itemsLines, 1);
        $cellHeight = 6 * $maxLines;

        // Customer Name (single line)
        $pdf->Cell($order_w[0], $cellHeight, $customerName, 1);

        // Save X and Y before multicell
        $x = $pdf->GetX();
        $y = $pdf->GetY();

        // Address (multiline)
        $pdf->MultiCell($order_w[1], 6, $address, 1);

        // Set cursor to right of Address, back to top of row
        $pdf->SetXY($x + $order_w[1], $y);

        // Items (multiline)
        $pdf->MultiCell($order_w[2], 6, $itemsStr, 1);

        // Set cursor to right of Items, back to top of row
        $pdf->SetXY($x + $order_w[1] + $order_w[2], $y);

        // Remaining cells with fixed height for alignment
        $pdf->Cell($order_w[3], $cellHeight, number_format($order['total'], 2), 1, 0, 'R');
        $pdf->Cell($order_w[4], $cellHeight, $order['payment_method'], 1, 0, 'C');
        $pdf->Cell($order_w[5], $cellHeight, $order['status'], 1, 1, 'C');
    }
} else {
    $pdf->Cell(array_sum($order_w), 10, "No orders found.", 1, 1, 'C');
}


// Calculate total sales from orders
$totalSalesResult = $conn->query("SELECT SUM(total) AS total_sales FROM orders");
$totalSales = 0;
if ($totalSalesResult && $totalSalesResult->num_rows > 0) {
    $rowTotal = $totalSalesResult->fetch_assoc();
    $totalSales = $rowTotal['total_sales'] ?? 0;
}

// Design Total Sales box
$pdf->SetFont('Arial', 'B', 16);
$pdf->SetTextColor(0, 0, 0);      // White text
$pdf->SetFillColor(255, 182, 193); 

// Calculate width of the box dynamically based on text length
$text = 'Total Sales:  ' . number_format($totalSales, 2);
$boxWidth = $pdf->GetStringWidth($text) + 20;  // add padding (10 on each side)
$boxHeight = 12;

// Get current X and Y position (to center box horizontally)
$x = ($pdf->GetPageWidth() - $boxWidth) / 2;
$y = $pdf->GetY() + 5;   // a little gap before the box

$pdf->SetXY($x, $y);
$pdf->Cell($boxWidth, $boxHeight, $text, 0, 1, 'C', true);

// Reset text color and add spacing after box
$pdf->SetTextColor(0, 0, 0);
$pdf->Ln(10);


$pdf->Output();
?>
