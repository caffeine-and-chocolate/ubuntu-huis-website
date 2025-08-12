<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    echo "<h2>Please log in to view your cart.</h2>";
    echo '<a href="login.php">Login</a>';
    exit();
}

$email = $_SESSION['email'];
$role = $_SESSION['role'] ?? 'buyer'; // default to buyer if not set

// Initialize cart structure per user
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}
if (!isset($_SESSION['cart'][$email])) {
    $_SESSION['cart'][$email] = [];
}

$cart = $_SESSION['cart'][$email];

// If cart is empty
if (empty($cart)) {
    echo "<h2>Your cart is empty.</h2>";

    $homePage = ($role === 'seller') ? 'sellerPage.php' : 'buyerPage.php';
    echo '<a href="' . $homePage . '">Return to Homepage</a>';
    exit();
}

$total = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Shopping Cart</title>

    <style>
        <style>
    /* Table Layout - Default for laptop & desktop */
    table {
        width: 80%;
        margin: auto;
        border-collapse: collapse;
        table-layout: auto;
        display: table;
    }

    th, td {
        padding: 12px;
        border: 1px solid #ccc;
        text-align: center;
        vertical-align: middle;
    }

    .table-wrapper {
        display: flex;
        justify-content: center;
        width: 100%;
    }

    img {
        max-width: 80px;
    }

    .total {
        font-weight: bold;
        font-size: 1.2em;
    }

    .actions {
        text-align: center;
        margin-top: 20px;
    }

    .actions a,
    .actions input[type=submit],
    .actions button {
        padding: 10px 20px;
        background: #a49367;
        color: white;
        text-decoration: none;
        border: none;
        border-radius: 4px;
        margin: 5px;
        cursor: pointer;
        display: inline-block;
    }

    .actions a:hover,
    .actions input[type=submit]:hover,
    .actions button:hover {
        background: #c1b385;
    }

    /* MOBILE RESPONSIVENESS */
    @media (max-width: 768px) {
        table {
            width: 100%;
            overflow-x: auto;
            display: block;
        }

        th, td {
            font-size: 13px;
            padding: 8px;
            white-space: nowrap;
        }

        img {
            max-width: 60px;
        }

        input[type="number"] {
            width: 60px;
        }

        .actions {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }

        .actions a,
        .actions input[type=submit],
        .actions button {
            width: 90%;
            max-width: 300px;
            font-size: 15px;
        }
    }
</style>


    </style>
</head>
<body>

    <?php include 'header.php'; ?>

    <h1 style="text-align:center;">Your Shopping Cart</h1>
    <form method="POST" action="modifyCart.php">
        <div class="table-wrapper">
            <table>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                    <th>Action</th>
                </tr>
                <?php foreach ($cart as $index => $item): 
                    $subtotal = $item['price'] * $item['quantity'];
                    $total += $subtotal;
                ?>
                <tr>
                    <td><img src="<?php echo htmlspecialchars($item['image']); ?>" alt="Product Image"></td>
                    <td><?php echo htmlspecialchars($item['name']); ?></td>
                    <td>R<?php echo number_format($item['price'], 2); ?></td>
                    <td>
                        <input type="number" name="quantities[<?php echo $index; ?>]" value="<?php echo $item['quantity']; ?>" min="1">
                    </td>
                    <td>R<?php echo number_format($subtotal, 2); ?></td>
                    <td>
                        <button type="submit" name="delete" value="<?php echo $index; ?>" onclick="return confirm('Remove this item?')">Delete</button>
                    </td>
                </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="4" class="total">Total</td>
                    <td class="total" colspan="2">R<?php echo number_format($total, 2); ?></td>
                </tr>
            </table>
        </div>

        <div class="actions">
            <input type="submit" name="update" value="Update Quantities">
            <a href="checkout.php">Proceed to Checkout</a>
            <a href="purchaseHistory.php">Order History</a>
            
        </div>

    </form>

    <?php include 'footer.php'; ?>
    
</body>
</html>
