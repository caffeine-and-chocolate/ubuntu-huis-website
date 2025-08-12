<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$userEmail = $_SESSION['email'];
$userRole = $_SESSION['role'] ?? ''; // Capture user role

if (!isset($_SESSION['cart'][$userEmail])) {
    header("Location: checkCart.php");
    exit();
}

// Handle quantity updates
if (isset($_POST['update']) && isset($_POST['quantities'])) {
    foreach ($_POST['quantities'] as $index => $qty) {
        $qty = max(1, intval($qty)); // Ensure quantity is at least 1
        $_SESSION['cart'][$userEmail][$index]['quantity'] = $qty;
    }
}

// Handle item deletion
if (isset($_POST['delete'])) {
    $deleteIndex = intval($_POST['delete']);
    if (isset($_SESSION['cart'][$userEmail][$deleteIndex])) {
        unset($_SESSION['cart'][$userEmail][$deleteIndex]);
        // Re-index the array
        $_SESSION['cart'][$userEmail] = array_values($_SESSION['cart'][$userEmail]);
    }
}

// Redirect back to cart after update or delete
header("Location: checkCart.php");
exit();
?>
