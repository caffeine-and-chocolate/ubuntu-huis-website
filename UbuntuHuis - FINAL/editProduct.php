<?php
session_start();
require_once 'config.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if seller is logged in
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'seller') {
    header("Location: login.php");
    exit();
}

$sellerEmail = $_SESSION['email'];

// Validate product ID
if (!isset($_GET['productId'])) {
    echo "Product not specified.";
    exit();
}

$productId = intval($_GET['productId']);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $desc = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $province = $_POST['province'];
    $city = $_POST['city'];

    // Handle image upload if a new one is provided
    $image = $_POST['existing_image'];
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Optional: Delete old image
        if (!empty($image) && file_exists($image)) {
            unlink($image);
        }

        $image = $uploadDir . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $image);
    }

    // Update query
    $stmt = $conn->prepare("UPDATE products SET name = ?, description = ?, price = ?, category = ?, province = ?, city = ?, image = ? WHERE productId = ? AND sellerEmail = ?");
    $stmt->bind_param("ssdssssis", $name, $desc, $price, $category, $province, $city, $image, $productId, $sellerEmail);
    $stmt->execute();
    $stmt->close();

    header("Location: manageProducts.php");
    exit();
}

// Load product data
$stmt = $conn->prepare("SELECT name, description, price, image, category, province, city FROM products WHERE productId = ? AND sellerEmail = ?");
$stmt->bind_param("is", $productId, $sellerEmail);
$stmt->execute();
$stmt->bind_result($name, $desc, $price, $image, $category, $province, $city);
if (!$stmt->fetch()) {
    echo "Product not found or access denied.";
    exit();
}
$stmt->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>

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

        form {
            background: white;
            padding: 30px;
            max-width: 500px;
            margin: auto;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }

        input, textarea, select {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        button {
            background-color: #c1b385;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #aa9e6a;
        }

        img {
            max-width: 100px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

    <?php include 'header.php'; ?>

    <h2>Edit Product</h2>

    <form method="post" enctype="multipart/form-data">
        <input type="text" name="name" value="<?= htmlspecialchars($name) ?>" placeholder="Product Name" required>
        <textarea name="description" placeholder="Description"><?= htmlspecialchars($desc) ?></textarea>
        <input type="number" name="price" value="<?= htmlspecialchars($price) ?>" step="0.01" required>

        <select name="category" required>
            <option value="">Select Category</option>
            <?php
            $categories = ["Artisan and Handmade Products", "Food and Produce", "Thrift and Secondhand", "Services", "Rentals"];
            foreach ($categories as $c) {
                echo "<option value=\"$c\" " . ($category == $c ? 'selected' : '') . ">$c</option>";
            }
            ?>
        </select>

        <select name="province" required>
            <option value="">Select Province</option>
            <?php
            $provinces = ["Eastern Cape", "Free State", "Gauteng", "Kwa-Zulu Natal", "Limpopo", "Mpumalanga", "Northern Cape", "North West", "Western Cape"];
            foreach ($provinces as $p) {
                echo "<option value=\"$p\" " . ($province == $p ? 'selected' : '') . ">$p</option>";
            }
            ?>
        </select>

        <select name="city" required>
            <option value="">Select City</option>
            <?php
            $cities = ["Bhisho", "Bloemfontein", "Cape Town", "Johannesburg", "Kimberly", "Mahikeng", "Mbombela", "Pietermaritzburg", "Polokwane"];
            foreach ($cities as $c) {
                echo "<option value=\"$c\" " . ($city == $c ? 'selected' : '') . ">$c</option>";
            }
            ?>
        </select>

        <label>Current Image:</label><br>
        <?php if (!empty($image) && file_exists($image)): ?>
            <img src="<?= htmlspecialchars($image) ?>" alt="Current Image"><br>
        <?php endif; ?>
        <input type="file" name="image">
        <input type="hidden" name="existing_image" value="<?= htmlspecialchars($image) ?>">

        <button type="submit">Update Product</button>
    </form>

    <?php include 'footer.php'; ?>
    
</body>
</html>
