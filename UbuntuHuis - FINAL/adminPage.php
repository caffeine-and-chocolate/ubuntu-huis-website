<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once 'config.php';

if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

if (isset($_GET['delete_user'])) {
    $userId = intval($_GET['delete_user']);
    $conn->query("DELETE FROM users WHERE userId = $userId");
}

if (isset($_GET['delete_product'])) {
    $productId = intval($_GET['delete_product']);
    $conn->query("DELETE FROM products WHERE id = $productId");
}

if (isset($_GET['delete_review'])) {
    $reviewId = intval($_GET['delete_review']);
    $conn->query("DELETE FROM reviews WHERE id = $reviewId");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_user'])) {
    $email = $_POST['email'];
    $name = $_POST['name'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $password, $role);
    $stmt->execute();
}

if (isset($_GET['block_user'])) {
    $userId = intval($_GET['block_user']);
    $conn->query("UPDATE users SET blocked = 1 WHERE userId = $userId");
}

if (isset($_GET['unblock_user'])) {
    $userId = intval($_GET['unblock_user']);
    $conn->query("UPDATE users SET blocked = 0 WHERE userId = $userId");
}

$allReviews = $conn->query("
    SELECT r.id, r.rating, r.feedback, u.name AS buyer_name, p.name AS product_name
    FROM reviews r
    JOIN users u ON r.userEmail = u.email
    JOIN products p ON r.productId = p.productId
    ORDER BY r.id DESC
");


$users = $conn->query("SELECT * FROM users");
$products = $conn->query("SELECT * FROM products");

$totalUsers = $conn->query("SELECT COUNT(*) AS total FROM users")->fetch_assoc()['total'];
$totalProducts = $conn->query("SELECT COUNT(*) AS total FROM products")->fetch_assoc()['total'];
$totalSellers = $conn->query("SELECT COUNT(*) AS total FROM users WHERE role = 'seller'")->fetch_assoc()['total'];
$totalBuyers = $conn->query("SELECT COUNT(*) AS total FROM users WHERE role = 'buyer'")->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

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
            width: 90%;
            margin: 0 auto;
        }

        .report, .section {
            background-color: white;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .buttons {
            display: flex;
            gap: 15px;
            margin: 20px 0;
        }

        .buttons button {
            padding: 10px 20px;
            background-color: #5a4b2c;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .buttons button:hover {
            background-color: #3f361f;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        .danger {
            color: red;
        }

        .analytics-btn {
            display: inline-block;
            margin-top: 20px;
            background-color: #0077cc;
            color: #fff;
            padding: 10px 15px;
            border-radius: 6px;
            text-decoration: none;
        }

        .hidden {
            display: none;
        }
    </style>

    <script>
        function showSection(id) {
            document.getElementById('createUserSection').classList.add('hidden');
            document.getElementById('allUsersSection').classList.add('hidden');
            document.getElementById('allProductsSection').classList.add('hidden');
            document.getElementById('allReviewsSection').classList.add('hidden');

            document.getElementById(id).classList.remove('hidden');
        }
    </script>
</head>
<body>

    <?php include 'header.php'; ?>

    <div class="container">
        <h1>Admin Panel - Ubuntu Huis</h1>

        <div class="report">
            <h2>System Report</h2>
            <p><strong>Total Users:</strong> <?= $totalUsers ?></p>
            <p><strong>Total Sellers:</strong> <?= $totalSellers ?></p>
            <p><strong>Total Buyers:</strong> <?= $totalBuyers ?></p>
            <p><strong>Total Products:</strong> <?= $totalProducts ?></p>
        </div>

        <div class="buttons">
            <button onclick="showSection('createUserSection')">➕ Create User</button>
            <button onclick="showSection('allUsersSection')">👥 View All Users</button>
            <button onclick="showSection('allProductsSection')">📦 View All Products</button>
            <button onclick="showSection('allReviewsSection')">📝 View All Reviews</button>

        </div>

        <div id="createUserSection" class="section hidden">
            <h2>Create New User</h2>
            <form method="post">
                <input type="hidden" name="create_user" value="1">
                <input type="text" name="name" placeholder="Full Name" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <select name="role" required>
                    <option value="">Select Role</option>
                    <option value="admin">Admin</option>
                    <option value="seller">Seller</option>
                    <option value="buyer">Buyer</option>
                </select>
                <button type="submit">Create</button>
            </form>
        </div>

        <div id="allUsersSection" class="section hidden">
            <h2>All Users</h2>
            <table>
                <tr>
                    <th>User ID</th><th>Name</th><th>Email</th><th>Role</th><th>Action</th>
                </tr>
                <?php while ($user = $users->fetch_assoc()): ?>
                    <tr>
                        <td><?= $user['userId'] ?></td>
                        <td><?= htmlspecialchars($user['name']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td><?= $user['role'] ?></td>
                        <td>
                        <a class="danger" href="?delete_user=<?= $user['userId'] ?>" onclick="return confirm('Delete this user?')">Delete</a>
                        <?php if ($user['blocked']): ?>
                            | <a href="?unblock_user=<?= $user['userId'] ?>">Unblock</a>
                        <?php else: ?>
                            | <a href="?block_user=<?= $user['userId'] ?>" onclick="return confirm('Block this user?')">Block</a>
                        <?php endif; ?>
                    </td>

                    </tr>
                <?php endwhile; ?>
            </table>
        </div>

        <div id="allProductsSection" class="section hidden">
            <h2>All Products</h2>
            <table>
                <tr>
                    <th>ID</th><th>Name</th><th>Seller</th><th>Price</th><th>Action</th>
                </tr>
                <?php while ($product = $products->fetch_assoc()): ?>
                    <tr>
                        <td><?= $product['productId'] ?></td>
                        <td><?= htmlspecialchars($product['name']) ?></td>
                        <td><?= htmlspecialchars($product['sellerEmail']) ?></td>
                        <td>R<?= $product['price'] ?></td>
                        <td><a class="danger" href="?delete_product=<?= $product['productId'] ?>" onclick="return confirm('Delete this product?')">Delete</a></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </div>

        <div id="allReviewsSection" class="section hidden">
    <h2>All Reviews</h2>
    <table>
        <tr>
            <th>ID</th><th>Product</th><th>Buyer</th><th>Rating</th><th>Feedback</th><th>Action</th>
        </tr>
        <?php while ($review = $allReviews->fetch_assoc()): ?>
            <tr>
                <td><?= $review['id'] ?></td>
                <td><?= htmlspecialchars($review['product_name']) ?></td>
                <td><?= htmlspecialchars($review['buyer_name']) ?></td>
                <td><?= $review['rating'] ?>⭐</td>
                <td><?= htmlspecialchars($review['feedback']) ?></td>
                <td><a class="danger" href="?delete_review=<?= $review['id'] ?>" onclick="return confirm('Delete this review?')">Delete</a></td>
            </tr>
        <?php endwhile; ?>
    </table>
</div>


        <a href="analyticsPage.php" class="analytics-btn">📊 View Analytics</a>
    </div>

    <?php include 'footer.php'; ?>
    
</body>
</html>
