<?php
session_start();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['paymentMethod'])) {
        $paymentMethod = $_POST['paymentMethod'];

        switch ($paymentMethod) {
            case 'card':
                header('Location: cardPage.php');
                exit();
            case 'applePay':
                header('Location: applePayPage.php');
                exit();
            case 'bankTransfer':
                header('Location: bankTransferPage.php');
                exit();
            default:
                // Fallback or error
                header('Location: checkout.php?error=invalid_selection');
                exit();
        }
    } else {
        header('Location: checkout.php?error=no_selection');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Page</title>
    <link rel="stylesheet" href="style.css">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

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

        .icon-enlarge{
            font-size: 21.5px;
        }

        section {
            margin: 40px auto;
            padding: 30px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        input[type="radio"] {
            margin-right: 10px;
        }

        input[type="submit"] {
            background-color: #c1b385;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            font-size: 1em;
            cursor: pointer;
            margin-top: 20px;
            display: block;
            width: 200px;
        }

        input[type="submit"]:hover {
            background-color:rgb(150, 138, 101);
        }

        .error {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }

        ion-icon {
            margin-right: 8px;
            vertical-align: middle;
        }
    </style>   
</head>
<body>

    <?php include 'header.php'; ?>

    <section>
        <h2>Please select your preferred payment method</h2>

        <section>

        <form action="checkout.php" method="POST">
            <label>
                <input type="radio" name="paymentMethod" value="card" required><ion-icon name="card-outline"></ion-icon> Credit/Debit Card</label><br><br>

            <label>
                <input type="radio" name="paymentMethod" value="applePay"><ion-icon name="logo-apple"></ion-icon> Apple Pay</label><br><br>

            <label>
                <input type="radio" name="paymentMethod" value="bankTransfer"><ion-icon name="cash-outline"></ion-icon><ion-icon name="arrow-redo"></ion-icon> Bank Transfer</label><br>

            <input type="submit" value="Submit">
        </form>
    </section>
    
</body>
</html>
