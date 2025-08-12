<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'seller') {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $desc = $_POST['description'];
    $price = $_POST['price'];
    $seller = $_SESSION['email'];
     $category = $_POST['category'];
    $province = $_POST['province'];
    $city = $_POST['city'];

    // Handle image upload
    $image = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $image = $uploadDir . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $image);
    }

    $stmt = $conn->prepare("INSERT INTO products (name, description, price, image, sellerEmail, category, province, city) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdsssss", $name, $desc, $price, $image, $seller, $category, $province, $city);
    $stmt->execute();

    echo "<script>
    alert('Product added successfully! You will be redirected to the homepage now now.');
    setTimeout(function() {
        window.location.href = 'sellerPage.php';
    }, 1000);
    </script>";
exit();

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    
    <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-04P6ZYYS4W"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-04P6ZYYS4W');
</script>

    <style>

        section {
            max-width: 600px;
            margin: 80px auto;
            background: #ffffff;
            padding: 20px;
        }

        form input[type="text"],
        form input[type="number"],
        form input[type="email"],
        form input[type="file"],
        form select,
        form textarea {
            width: 250px;
            padding: 12px 15px;
            margin-top: 4px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 1em;
            background-color: #f9f9f9;
        }

        form textarea {
            height: 100px;
            resize: vertical;
        }

        form select {
            background-color: #f9f9f9;
        }

        form button {
            width: 100%;
            padding: 12px;
            background-color:#c1b385;
            color: white;
            font-size: 1em;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        form button:hover {
            background-color: rgb(150, 138, 101);
        }

        h2{
            position: center;
            color: #c1b385;
        }

    </style> 

</head>    

<body>

    <?php include 'header.php'; ?>

    <h2>PLEASE ADD PRODUCTS BELOW</h2>


    <section>
    <form method="post" enctype="multipart/form-data">

        <input type="text" name="name" placeholder="Product Name" required><br><br>
        <textarea name="description" placeholder="Description"></textarea><br><br>
        <input type="number" step="10.00" name="price" placeholder="Price" required><br><br>

        <select name="category" required>
            <option value="">Select Category</option>
            <option value="Artisan and Handmade Products">Artisan and Handmade Products</option>
            <option value="Food and Produce">Food and Produce</option>
            <option value="Thrift and Secondhand">Thrift and Secondhand</option>
            <option value="Services">Services</option>
            <option value="Rentals">Rentals</option>
        </select><br><br>

        <select name="province" required>
            <option value="">Select Province</option>
            <option value="Eastern Cape">Eastern Cape</option>
            <option value="Free State">Free State</option>
            <option value="Gauteng">Gauteng</option>
            <option value="Kwa-Zulu Natal">Kwa-Zulu Natal</option>
            <option value="Limpopo">Limpopo</option>
            <option value="Mpumalanga">Mpumalanga</option>
            <option value="Northern Cape">Northern Cape</option>
            <option value="North West">North West</option>
            <option value="Western Cape">Western Cape</option>
        </select><br><br>

        <select name="city" required>
            <option value="">Select City</option>
            <option value="Bhisho">Bhisho</option>
            <option value="Bloemfontein">Bloemfontein</option>
            <option value="Cape Town">Cape Town</option>
            <option value="Johannesburg">Johannesburg</option>
            <option value="Kimberly">Kimberly</option>
            <option value="Mahikeng">Mahikeng</option>
            <option value="Mbombela">Mbombela</option>
            <option value="Pietermaritzburg">Pietermaritzburg</option>
            <option value="Polokwane">Polokwane</option>
        </select><br><br>

        <input type="file" name="image"><br><br>
        <button type="submit">Add Product</button>
    </form>

    </section>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

</body>

</html>