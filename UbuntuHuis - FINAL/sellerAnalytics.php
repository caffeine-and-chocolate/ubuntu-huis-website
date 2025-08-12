<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'seller') {
    header("Location: login.php");
    exit();
}

$sellerEmail = $_SESSION['email'];
$pageType = 'seller';
include 'header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Seller Analytics</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            padding-top: 150px;
            background-color: #fff;
        }

        .analytics-container {
            max-width: 900px;
            margin: 0 auto;
            padding: 30px;
        }

        h2 {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f5f5f5;
        }
    </style>
</head>
<body>

    <?php include 'header.php'; ?>
    
    <div class="analytics-container">
        <h2>Your Product Sales Analytics</h2>

        <table>
            <tr>
                <th>Product Name</th>
                <th>Total Quantity Sold</th>
                <th>Total Revenue (R)</th>
            </tr>

            <?php
            $sql = "
                SELECT p.name AS product_name,
                       SUM(oi.quantity) AS total_quantity,
                       SUM(oi.quantity * oi.price) AS total_revenue
                FROM products p
                JOIN orderItems oi ON p.productId = oi.productId
                JOIN orders o ON o.id = oi.orderId
                WHERE p.sellerEmail = ?
                  AND o.status = 1
                GROUP BY p.productId
            ";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $sellerEmail);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 0) {
                echo "<tr><td colspan='3'>No sales data found.</td></tr>";
            } else {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['product_name']}</td>
                            <td>{$row['total_quantity']}</td>
                            <td>R" . number_format($row['total_revenue'], 2) . "</td>
                          </tr>";
                }
            }
            ?>
        </table>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>