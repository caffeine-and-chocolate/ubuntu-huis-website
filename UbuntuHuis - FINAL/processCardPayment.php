<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['email'])) {
        die("Not logged in.");
    }

    $email = $_SESSION['email'];

    // Simple card validation
    $cardName = $_POST['cardName'] ?? '';
    $cardNumber = $_POST['cardNumber'] ?? '';
    $expiry = $_POST['expiry'] ?? '';
    $cvv = $_POST['cvv'] ?? '';

    if (!preg_match('/^\d{16}$/', $cardNumber)) {
        die("Invalid card number.");
    }

    if (!preg_match('/^\d{3}$/', $cvv)) {
        die("Invalid CVV.");
    }

    // Step 1: Get userId
    $userStmt = $conn->prepare("SELECT userId FROM users WHERE email = ?");
    $userStmt->bind_param("s", $email);
    $userStmt->execute();
    $userResult = $userStmt->get_result();
    $userId = $userResult->fetch_assoc()['userId'] ?? null;
    $userStmt->close();

    if (!$userId) {
        die("User not found.");
    }

    // Step 2: Create new order
    $orderStatus = 1;
    $orderInsert = $conn->prepare("INSERT INTO orders (userId, status) VALUES (?, ?)");
    $orderInsert->bind_param("ii", $userId, $orderStatus);
    $orderInsert->execute();
    $orderId = $orderInsert->insert_id;
    $orderInsert->close();

    // Step 3: Fetch cart items with price
        $sql = "SELECT c.productId, c.quantity, p.price 
            FROM cart c 
            JOIN products p ON c.productId = p.productId 
            WHERE c.buyerEmail = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $cartResult = $stmt->get_result();

    $purchaseInsert = $conn->prepare("INSERT INTO purchases (buyerEmail, productId, purchaseDate, reviewed) VALUES (?, ?, NOW(), 0)");
    $orderItemInsert = $conn->prepare("INSERT INTO orderItems (orderId, productId, quantity, price) VALUES (?, ?, ?, ?)");

    while ($row = $cartResult->fetch_assoc()) {
        $productId = $row['productId'];
        $quantity = $row['quantity'];
        $price = $row['price'];

        $purchaseInsert->bind_param("si", $email, $productId);
        $purchaseInsert->execute();

        $orderItemInsert->bind_param("iiid", $orderId, $productId, $quantity, $price);
        $orderItemInsert->execute();
    }


    // Cleanup
    $stmt->close();
    $purchaseInsert->close();
    $orderItemInsert->close();

    // Step 5: Clear cart
    $clearCart = $conn->prepare("DELETE FROM cart WHERE buyerEmail = ?");
    $clearCart->bind_param("s", $email);
    $clearCart->execute();
    $clearCart->close();

    // Step 6: Redirect
    header("Location: paymentSuccessful.php");
    exit();
} else {
    echo "Invalid request method.";
}
