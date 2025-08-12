<?php
session_start();
require_once 'config.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Filters
$category = $_GET['category'] ?? '';
$province = $_GET['province'] ?? '';
$city = $_GET['city'] ?? '';

$sql = "SELECT * FROM products WHERE 1=1";
$parameters = [];
$type = '';

if ($category) {
    $sql .= " AND category = ?";
    $parameters[] = $category;
    $type .= 's';
}
if ($province) {
    $sql .= " AND province = ?";
    $parameters[] = $province;
    $type .= 's';
}
if ($city) {
    $sql .= " AND city = ?";
    $parameters[] = $city;
    $type .= 's';
}

$productStmt = $conn->prepare($sql);
if (!$productStmt) {
    die("Prepare failed: " . $conn->error);
}

if (!empty($parameters)) {
    $productStmt->bind_param($type, ...$parameters);
}

$productStmt->execute();
$result = $productStmt->get_result();

// ✅ Optional: Track individual product view (only if product_id is in URL)
if (isset($_GET['product_id'])) {
    $productId = (int)$_GET['product_id'];
    $viewerEmail = $_SESSION['email'] ?? null;

    if ($viewerEmail) {
        $trackStmt = $conn->prepare("INSERT INTO productViews (productId, viewerEmail) VALUES (?, ?)");
        $trackStmt->bind_param("is", $productId, $viewerEmail);
        $trackStmt->execute();
        $trackStmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ubuntu Huis - Products</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-04P6ZYYS4W"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', 'G-04P6ZYYS4W');
    </script>

    <style>
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
            padding: 90px 60px; 
        }

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

        .placeProducts {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
        }

        .productBox {
            background-color: white;
            width: 400px;
            text-align: center;
            padding: 15px;
            border-radius: 4px;
            margin: 15px 0;
            box-shadow: 0 0 5px rgba(0,0,0,0.1);
        }

        .productBox img {
            height: 150px;
            width: 100%;
            object-fit: contain;
            background-color: white;
            margin-bottom: 10px;
            border-radius: 4px;
        }


        .productBox h4 {
            color: #162938;
        }

        .productBox p {
            line-height: 1.6;
        }

        .productBox form,
        .productBox a {
            margin-top: 10px;
            display: inline-block;
        }

        .productBox input[type="submit"],
        .productBox button {
            background-color: #162938;
            color: white;
            border: none;
            padding: 8px 16px;
            cursor: pointer;
            border-radius: 4px;
        }

        .productBox input[type="submit"]:hover,
        .productBox button:hover {
            background-color: #2c3e50;
        }
    </style>
</head>
<body>

<?php include 'header.php'; ?>

<section class="placeProducts">
    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="productBox">
                <?php if ($row['image']): ?>
                    <img src="<?= htmlspecialchars($row['image']) ?>" alt="Product Image">
                <?php endif; ?>

                <h4><?= htmlspecialchars($row['name']) ?></h4>
                <p>
                    <?= htmlspecialchars($row['description']) ?><br>
                    <strong>R <?= number_format($row['price'], 2) ?></strong><br>
                    <?= htmlspecialchars($row['city']) ?>, <?= htmlspecialchars($row['province']) ?><br>
                    Category: <?= htmlspecialchars($row['category']) ?>
                </p>

                <form method="post" action="addToCart.php">
                    <input type="hidden" name="productId" value="<?= $row['productId'] ?>">
                    <input type="number" name="quantity" value="1" min="1" style="width: 60px;">
                    <input type="submit" value="Add to Cart">
                </form>

                <a href="sellersProfile.php?seller=<?= urlencode($row['sellerEmail']) ?>">
                    <button type="button">View Seller Profile</button>
                </a>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p style="text-align:center;">There are currently no products under this filter but will be available once sellers have uploaded them.<br> Sorry for any inconveniances this might cause.</p>
    <?php endif; ?>
</section>

<?php include 'footer.php'; ?>
</body>
</html>
