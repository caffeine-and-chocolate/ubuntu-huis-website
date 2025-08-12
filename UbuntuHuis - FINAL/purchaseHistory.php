<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once 'config.php';

// Redirect if not logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['email'];

// Handle Review Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_review'])) {
    $product_id = $_POST['product_id'];
    $rating = $_POST['rating'];
    $review = htmlspecialchars($_POST['review'], ENT_QUOTES, 'UTF-8');

    // Insert review
    $stmt = $conn->prepare("INSERT INTO reviews (productId, userEmail, rating, feedback) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isis", $product_id, $email, $rating, $review);
    $stmt->execute();

    // Mark as reviewed
    $stmt = $conn->prepare("UPDATE purchases SET reviewed = 1 WHERE buyerEmail = ? AND productId = ?");
    $stmt->bind_param("si", $email, $product_id);
    $stmt->execute();
}

// Fetch Purchases
$stmt = $conn->prepare("
    SELECT p.productId, p.name, p.description, p.image, p.price, pu.reviewed 
    FROM purchases pu 
    JOIN products p ON pu.productId = p.productId 
    WHERE pu.buyerEmail = ?
");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Purchases</title>
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
        .container {
    max-width: 1200px;
    margin: auto;
    padding: 20px;
}

h2 {
    margin-bottom: 30px;
    text-align: center;
    font-size: 2em;
    color: #444;
}

.product-list {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: 20px;
}

.product {
    border: none;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    padding: 20px;
    background: #fff;
    transition: transform 0.3s ease;
}

.product:hover {
    transform: translateY(-5px);
}

.product img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 8px;
}

.product h3 {
    margin-top: 15px;
    font-size: 1.3em;
    color: #333;
}

.product p {
    margin: 10px 0;
    color: #555;
}

textarea {
    width: 100%;
    padding: 10px;
    border-radius: 6px;
    border: 1px solid #ccc;
    font-size: 0.95em;
    resize: vertical;
}

button[type="submit"] {
    background-color: #c1b385;
    color: white;
    border: none;
    padding: 10px 16px;
    border-radius: 6px;
    font-size: 1em;
    cursor: pointer;
    margin-top: 10px;
    transition: background-color 0.3s ease;
}

button[type="submit"]:hover {
    background-color: #a99863;
}

.stars {
    display: flex;
    flex-direction: row-reverse;
    justify-content: flex-end;
    margin-top: 10px;
}

.stars label {
    font-size: 24px;
    color: #ccc;
    transition: color 0.2s;
}

.stars input:checked ~ label,
.stars label:hover,
.stars label:hover ~ label {
    color: gold;
}

    </style>
</head>
<body>

    <?php include 'header.php'; ?>

    <h2>My Purchased Products</h2>

<section class="placeProducts">
<?php if ($result->num_rows === 0): ?>
    <p style="text-align:center;">You have not purchased any products yet.</p>
<?php else: ?>
    <?php while ($row = $result->fetch_assoc()): ?>
        <div class="productBox">
            <?php if ($row['image']): ?>
                <img src="<?= htmlspecialchars($row['image']) ?>" alt="Product Image">
            <?php endif; ?>

            <h4><?= htmlspecialchars($row['name']) ?></h4>
            <p>
                <?= htmlspecialchars($row['description']) ?><br>
                <strong>R <?= number_format($row['price'], 2) ?></strong>
            </p>

            <?php if (!$row['reviewed']): ?>
                <form method="POST">
                    <input type="hidden" name="product_id" value="<?= $row['productId'] ?>">

                    <label for="review">Write a review:</label><br>
                    <textarea name="review" rows="3" required></textarea><br>

                    <div class="stars" style="justify-content:center;">
                        <?php for ($i = 5; $i >= 1; $i--): ?>
                            <input type="radio" id="star<?= $i . '_' . $row['productId'] ?>" name="rating" value="<?= $i ?>" required>
                            <label for="star<?= $i . '_' . $row['productId'] ?>">★</label>
                        <?php endfor; ?>
                    </div><br>

                    <button type="submit" name="submit_review">Submit Review</button>
                </form>
            <?php else: ?>
                <p><em>You've already reviewed this product.</em></p>
            <?php endif; ?>
        </div>
    <?php endwhile; ?>
<?php endif; ?>
</section>


    <?php include 'footer.php'; ?>
    
</body>
</html>
