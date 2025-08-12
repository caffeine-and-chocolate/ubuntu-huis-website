<?php
session_start();
require_once 'config.php';
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'buyer') {
    header('Location: login.php'); exit();
}

$buyer = $_SESSION['email'];
$productId = intval($_GET['product']);
if (!$productId) exit("Product not specified.");

// Optional: Verify purchase from orders table
# ...

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rating = intval($_POST['rating']);
    $msg = trim($_POST['message']);
    if ($rating>=1 && $rating<=5 && $msg !== '') {
        $stmt = $conn->prepare("INSERT INTO product_reviews (product_id, buyer, rating, message, created_at) VALUES (?, ?, ?, ?, NOW())");
        $stmt->bind_param("isis", $productId, $buyer, $rating, $msg);
        $stmt->execute();
        header("Location: product.php?id=$productId");
        exit();
    } else {
        $error = "Please provide rating (1–5) and non-empty message.";
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Review Product</title>

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
</style>

</head>
<body>

    <?php include 'header.php'; ?>

    <h2>Leave a Review</h2>
    <?php if (isset($error)): ?><p style="color:red"><?= htmlspecialchars($error) ?></p><?php endif; ?>
    <form method="post">
        <label>Rating:
            <select name="rating" required>
                <option value="">--</option>
                <?php for ($i=1;$i<=5;$i++) echo "<option value=\"$i\">$i</option>"; ?>
            </select>
        </label><br><br>
        <label>Comment:<br>
            <textarea name="message" rows="5" cols="50" required></textarea>
        </label><br><br>
        <button type="submit">Submit Review</button>
    </form>

    <?php include 'footer.php'; ?>
    
</body>
</html>
