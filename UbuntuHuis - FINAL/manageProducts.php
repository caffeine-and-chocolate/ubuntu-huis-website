<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once 'config.php';

if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'seller') {
    header("Location: login.php");
    exit();
}

$sellerEmail = $_SESSION['email'];

// DELETE PRODUCT
if (isset($_GET['delete'])) {
    $productId = intval($_GET['delete']);

    // Get image path for deletion
    $stmt = $conn->prepare("SELECT image FROM products WHERE productId = ? AND sellerEmail = ?");
    $stmt->bind_param("is", $productId, $sellerEmail);
    $stmt->execute();
    $stmt->bind_result($imagePath);
    $stmt->fetch();
    $stmt->close();

    if (!empty($imagePath) && file_exists($imagePath)) {
        unlink($imagePath);
    }

    // First delete from cart table
    $stmt = $conn->prepare("DELETE FROM cart WHERE productId = ?");
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $stmt->close();

    // Then delete from products
    $stmt = $conn->prepare("DELETE FROM products WHERE productId = ? AND sellerEmail = ?");
    $stmt->bind_param("is", $productId, $sellerEmail);
    $stmt->execute();
    $stmt->close();


    header("Location: manageProducts.php");
    exit();
}

// FETCH PRODUCTS
$stmt = $conn->prepare("SELECT productId, name, description, price, image, category, province, city FROM products WHERE sellerEmail = ?");
$stmt->bind_param("s", $sellerEmail);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage My Products</title>

    <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-04P6ZYYS4W"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-04P6ZYYS4W');
</script>

    <style>
        /* body {
            font-family: Arial, sans-serif;
            padding: 50px;
            background: #f7f7f7;
        } */

                        * {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    padding-top: 100px;
    color: #333;
}

/* Header Styling */
header {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    background-color: rgba(0, 0, 0, 0.7);
    backdrop-filter: blur(10px);
    color: white;
    padding: 20px 5%;
    display: flex;
    justify-content: space-between;
    align-items: center;
    z-index: 999;
}

header h1 {
    margin: 0;
    font-size: 1.8em;
}

.navigation a {
    color: #f4f4f4;
    text-decoration: none;
    margin-left: 20px;
    font-size: 1.05em;
    position: relative;
}

.navigation a:hover::after {
    content: '';
    position: absolute;
    bottom: -3px;
    left: 0;
    width: 100%;
    height: 2px;
    background: #f4f4f4;
}

        h2 {
            color: #c1b385;
        }

        .product {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .product img {
            max-width: 150px;
            height: auto;
            border-radius: 4px;
        }

        .actions a {
            margin-right: 15px;
            text-decoration: none;
            color: #ffffff;
            background-color: #c1b385;
            padding: 6px 12px;
            border-radius: 5px;
        }

        .actions a.delete {
            background-color: #e05c4e;
        }

        .actions a:hover {
            opacity: 0.8;
        }

    </style>
</head>
<body>

    <?php include 'header.php'; ?>

    <h1>My Products</h1>

    <div style="margin-top: 100px;">
        <h2>Manage Your Products</h2>

        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="product">
                <h3><?= htmlspecialchars($row['name']) ?> - R<?= number_format($row['price'], 2) ?></h3>
                <p><strong>Category:</strong> <?= htmlspecialchars($row['category']) ?></p>
                <p><strong>Location:</strong> <?= htmlspecialchars($row['city']) ?>, <?= htmlspecialchars($row['province']) ?></p>
                <p><?= nl2br(htmlspecialchars($row['description'])) ?></p>
                <?php if (!empty($row['image']) && file_exists($row['image'])): ?>
                    <img src="<?= htmlspecialchars($row['image']) ?>" alt="Product Image">
                <?php endif; ?>
                <div class="actions">
                    <a href="editProduct.php?productId=<?= $row['productId'] ?>">Edit</a>
                    <a href="manageProducts.php?delete=<?= $row['productId'] ?>" class="delete" onclick="return confirm('Are you sure you want to delete this product?')">Delete</a>
                </div>
            </div>
        <?php endwhile; ?>
    </div>

    <?php include 'footer.php'; ?>

</body>
</html>
