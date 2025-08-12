<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'seller') {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['email'];

// Fetch profile
$stmt = $conn->prepare("SELECT * FROM sellers WHERE email=?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Profile not found.";
    exit();
}

$data = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>

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

    <h2>Edit Your Profile</h2>
    <form action="uploadSellerProfile.php" method="POST" enctype="multipart/form-data">
        <label>Name:</label>
        <input type="text" name="name" value="<?= htmlspecialchars($data['name']) ?>" required><br>

        <label>Email (readonly):</label>
        <input type="email" name="email" value="<?= htmlspecialchars($data['email']) ?>" readonly><br>

        <label>Contact:</label>
        <input type="text" name="contact" value="<?= htmlspecialchars($data['contact']) ?>"><br>

        <label>Area:</label>
        <input type="text" name="area" value="<?= htmlspecialchars($data['area']) ?>"><br>

        <label>Category:</label>
        <input type="text" name="category" value="<?= htmlspecialchars($data['category']) ?>"><br>

        <label>Change Profile Picture:</label>
        <input type="file" name="image"><br><br>

        <button type="submit">Update Profile</button>
    </form>

    <?php include 'footer.php'; ?>
    
</body>
</html>
