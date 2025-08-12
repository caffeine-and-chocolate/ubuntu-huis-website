<?php
session_start();
require_once 'config.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Determine which seller profile to show
$seller = $_GET['seller'] ?? ($_SESSION['role'] === 'seller' ? $_SESSION['email'] : null);
if (!$seller) {
    echo "Seller not specified.";
    exit();
}

// Fetch seller profile
$stmt = $conn->prepare("SELECT name, contact, email, area, category, image FROM sellers WHERE email = ?");
$stmt->bind_param("s", $seller);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Seller profile not found.";
    exit();
}

$profile = $result->fetch_assoc();

$stmt = $conn->prepare("
    SELECT 
        r.rating, 
        r.feedback, 
        r.userEmail, 
        u.name AS buyer_name,
        r.productId, 
        p.name AS product_name,
        p.image AS product_image
    FROM reviews r
    JOIN products p ON r.productId = p.productId
    LEFT JOIN users u ON r.userEmail = u.email
    WHERE p.sellerEmail = ?
    ORDER BY r.id DESC
");

$stmt->bind_param("s", $seller);
$stmt->execute();
$productReviews = $stmt->get_result();

?>
<!DOCTYPE html>
<html>
<head>
    <title><?= htmlspecialchars($profile['name']) ?>'s Profile</title>

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

    <h1><?= htmlspecialchars($profile['name']) ?>'s Seller Profile</h1>

    <?php if (!empty($profile['image']) && file_exists($profile['image'])): ?>
        <img src="<?= htmlspecialchars($profile['image']) ?>" style="max-width:150px;" alt="Profile picture"><br>
    <?php endif; ?>

    <p><strong>Category:</strong> <?= htmlspecialchars($profile['category']) ?></p>
    <p><strong>Location:</strong> <?= htmlspecialchars($profile['area']) ?></p>

    <h3>Contact</h3>
    <p><strong>Email:</strong> <?= htmlspecialchars($profile['email']) ?></p>
    <?php if (!empty($profile['contact'])): ?>
        <p><strong>Phone:</strong> <?= htmlspecialchars($profile['contact']) ?></p>
    <?php endif; ?>

    <?php
    if (isset($_SESSION['email'], $_SESSION['role']) && $_SESSION['role'] === 'seller' && $_SESSION['email'] === $profile['email']): ?>
        <p><a href="editSellerProfile.php">Edit Profile</a></p>
    <?php endif; ?>


    <h2>Product Reviews</h2>
<?php if ($productReviews->num_rows === 0): ?>
    <p>No product reviews yet.</p>
<?php else: ?>
    <?php while ($review = $productReviews->fetch_assoc()): ?>
        <div style="display:flex; gap:15px; align-items:flex-start; border:1px solid #ccc; padding:15px; margin:15px 0;">
            <?php if (!empty($review['product_image']) && file_exists($review['product_image'])): ?>
                <img src="<?= htmlspecialchars($review['product_image']) ?>" alt="Product Image" style="width:100px; height:100px; object-fit:cover; border-radius:8px;">
            <?php endif; ?>
            
            <div>
                <strong><?= htmlspecialchars($review['buyer_name'] ?? 'Unknown Buyer') ?></strong> reviewed 
                <strong><?= htmlspecialchars($review['product_name']) ?></strong><br>

                <!-- Star rating -->
                <div style="color: #ffc107; font-size: 18px; margin: 5px 0;">
                    <?php
                    $fullStars = (int)$review['rating'];
                    for ($i = 0; $i < 5; $i++) {
                        echo $i < $fullStars ? '★' : '☆';
                    }
                    ?>
                    (<?= $review['rating'] ?>/5)
                </div>

                <p><?= nl2br(htmlspecialchars($review['feedback'])) ?></p>
            </div>
        </div>
    <?php endwhile; ?>
<?php endif; ?>

    <a href="manageProducts.php"><button>Manage My Products</button></a><br><br>
    <a href="sellerAnalytics.php"">📊 View Analytics</a>

    <?php include 'footer.php'; ?>
    
</body>
</html>
