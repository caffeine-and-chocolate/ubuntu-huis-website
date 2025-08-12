<?php
session_start();
require_once 'config.php';

// Ensure the user is a logged-in seller
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'seller') {
    header("Location: login.php");
    exit();
}

$sellerEmail = $_SESSION['email'];

// Check if profile exists in the 'sellers' table
$stmt = $conn->prepare("SELECT id FROM sellers WHERE email = ?");
$stmt->bind_param("s", $sellerEmail);
$stmt->execute();
$stmt->store_result();
$hasProfile = $stmt->num_rows > 0;
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Seller Profile</title>
    <link rel="stylesheet" href="style.css">

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

/* Section/Form Styling */
section {
    max-width: 600px;
    margin: 40px auto;
    background: white;
    padding: 40px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

section h2 {
    margin-bottom: 30px;
    font-size: 1.5em;
    text-align: center;
    color: #c1b385;
}

label {
    display: block;
    margin-bottom: 6px;
    font-weight: bold;
    font-size: 0.95em;
}

input[type="text"],
select {
    width: 100%;
    padding: 12px 14px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-size: 1em;
    background-color: #f9f9f9;
}
    </style>
</head>
<body>

    <?php include 'header.php'; ?>

    <section>
        <form action="uploadSellerProfile.php" method="POST" enctype="multipart/form-data">
            <h2>Please create a Profile below</h2>

            <label for="name">Full Name:</label>
            <input type="text" id="name" name="name" placeholder="Enter your full name" required>

            <label for="email">Email Address:</label>
            <input type="text" id="email" name="email" value="<?= htmlspecialchars($sellerEmail) ?>" readonly>

            <label for="phoneNumber">Phone number:</label>
            <input type="text" id="contact" name="contact" placeholder="Enter your phone number (optional)">

            <label for="area">Preferred Area of Business:</label>
            <select name="area" id="area" required>
                <option value="">Select preferred area</option>
                <option value="Bhisho">Bhisho</option>
                <option value="Bloemfontein">Bloemfontein</option>
                <option value="Cape Town">Cape Town</option>
                <option value="Johannesburg">Johannesburg</option>
                <option value="Kimberly">Kimberly</option>
                <option value="Mahikeng">Mahikeng</option>
                <option value="Mbombela">Mbombela</option>
                <option value="Pietermaritzburg">Pietermaritzburg</option>
                <option value="Polokwane">Polokwane</option>
            </select>

            <label for="category">Line of Focus:</label>
            <select name="category" id="category" required>
                <option value="">Select Line of Focus</option>
                <option value="Artisan and Handmade Products">Artisan and Handmade Products</option>
                <option value="Food and Produce">Food and Produce</option>
                <option value="Thrift and Secondhand">Thrift and Secondhand</option>
                <option value="Services">Services</option>
                <option value="Rentals">Rentals</option>
            </select>

            <label for="profilePicture">Upload Your Profile Picture:</label>
            <input type="file" name="image"><br><br>

            <button type="submit">Create Profile</button>
        </form>

        <?php if ($hasProfile): ?>
            <p style="text-align: center; margin-top: 20px;">
                Already have a profile? <a href="viewSellerProfile.php?email=<?= urlencode($_SESSION['email']) ?>">Click here to view it</a>
            </p>
        <?php endif; ?>
    </section>

    <?php include 'footer.php'; ?>

</body>
</html>
