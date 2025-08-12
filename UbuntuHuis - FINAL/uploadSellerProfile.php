<?php
session_start();
require_once 'config.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['email'], $_SESSION['role']) || $_SESSION['role'] !== 'seller') {
    die("Unauthorized access.");
}

$email = $_SESSION['email'];
$name = $_POST['name'] ?? '';
$contact = $_POST['contact'] ?? '';
$area = $_POST['area'] ?? '';
$category = $_POST['category'] ?? '';

// File upload
$imagePath = '';
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = 'uploads/';
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

    $fileName = basename($_FILES['image']['name']);
    $imagePath = $uploadDir . time() . "_" . $fileName;
    move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
}

// Check if profile exists
$stmt = $conn->prepare("SELECT id FROM sellers WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();
$exists = $stmt->num_rows > 0;
$stmt->close();

if ($exists) {
    if ($imagePath) {
        $stmt = $conn->prepare("UPDATE sellers SET name=?, contact=?, area=?, category=?, image=? WHERE email=?");
        $stmt->bind_param("ssssss", $name, $contact, $area, $category, $imagePath, $email);
    } else {
        $stmt = $conn->prepare("UPDATE sellers SET name=?, contact=?, area=?, category=? WHERE email=?");
        $stmt->bind_param("sssss", $name, $contact, $area, $category, $email);
    }
} else {
    $stmt = $conn->prepare("INSERT INTO sellers (name, email, contact, area, category, image) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $name, $email, $contact, $area, $category, $imagePath);
}

if ($stmt->execute()) {
    header("Location: viewSellerProfile.php?seller=" . urlencode($email));
    exit();
} else {
    echo "Database error: " . $stmt->error;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Seller Profile</title>

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


    <?php include 'footer.php'; ?>
    
</body>
</html>