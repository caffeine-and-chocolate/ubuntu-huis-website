<?php
session_start();
require_once 'config.php';

// Ensure the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['email'];

// Ensure the request is a POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = $_POST['productId'] ?? null;
    $quantity = $_POST['quantity'] ?? 1;

    if (!$productId || $quantity < 1) {
        header("Location: index.php");
        exit();
    }

    // ✅ Insert into database cart (make sure buyerEmail is saved)
    $stmt = $conn->prepare("INSERT INTO cart (productId, quantity, buyerEmail) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $productId, $quantity, $email);
    $stmt->execute();

    // ✅ Also store in session (optional for checkCart display)
    $stmt = $conn->prepare("SELECT * FROM products WHERE productId = ?");
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    if (!$product) {
        header("Location: index.php");
        exit();
    }

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if (!isset($_SESSION['cart'][$email])) {
        $_SESSION['cart'][$email] = [];
    }

    $found = false;
    foreach ($_SESSION['cart'][$email] as &$item) {
        if ($item['id'] == $product['productId']) {
            $item['quantity'] += $quantity;
            $found = true;
            break;
        }
    }
    unset($item);

    if (!$found) {
        $_SESSION['cart'][$email][] = [
            'id' => $product['productId'],
            'name' => $product['name'],
            'price' => $product['price'],
            'image' => $product['image'],
            'quantity' => $quantity
        ];
    }

    header("Location: checkCart.php");
    exit();
}

header("Location: index.html");
exit();

?>