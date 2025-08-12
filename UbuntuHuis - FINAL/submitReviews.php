<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['email'])) {
    echo "Unauthorized.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'];
    $review = trim($_POST['review']);

    // Get user ID
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $_SESSION['email']);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
    $user_id = $user['id'];

    // Insert review
    $insert = $conn->prepare("INSERT INTO reviews (user_id, product_id, review_text) VALUES (?, ?, ?)");
    $insert->bind_param("iis", $user_id, $product_id, $review);
    $insert->execute();

    header("Location: purchaseHistory.php");
    exit();
}
?>
