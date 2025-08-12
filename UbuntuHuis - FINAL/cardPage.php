<?php
session_start();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>applePayPage</title>
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
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background: #e6f0f5;
        }

        header{
            position: fixed;
            top: 0;
            left:0;
            width: 90%;
            padding: 0 5%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: rgba(255, 255, 255, 0.3); 
            backdrop-filter: blur(30px);
            z-index: 999;
        }

        main, .content, .wrapper {
            margin-top: 100px; /* Ensures the content clears the header */
        }

        header h1{
            line-height: 64px;
            font-size: 50px;
            color: #c1b385;
        }

        .navigation a{
            position: relative;
            font-size: 1.1em;
            color: #c1b385;
            text-decoration: none;
            font-weight: 500;
            margin-left: 40px;
        }

        .navigation a::after {
            content:'';
            position: absolute;
            left: 0;
            bottom: -2px;
            width: 100%;
            height: 2px;
            background: rgb(150, 138, 101);
            border-radius: 5px;
            transform: scaleX(0);
            transition: transform .5s;
        }

        .navigation a:hover::after{
            transform: scaleX(1);
        }

        main, .wrapper, .content {
            padding-top: 80px; /* Should be slightly more than header height */
        }

        .payment-container {
            margin-top: 30px;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            width: 420px;
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 15px;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #a49367;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background: #c1b385;
        }

        .note {
            font-size: 13px;
            color: #555;
            margin-top: 10px;
            text-align: center;
        }

        .flex-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: calc(100vh - 100px); /* Adjusts for 80px header + padding */
        }

    </style>
</head>
<body>

    <?php include 'header.php'; ?>

    <main class="content">
        <div class="flex-wrapper">
            <div class="payment-container">
                <h2>Card Payment</h2>
                <form action="processCardPayment.php" method="POST">
                    <label for="cardName">Cardholder Name</label>
                    <input type="text" name="cardName" id="cardName" required>

                    <label for="cardNumber">Card Number</label>
                    <input type="tel" name="cardNumber" id="cardNumber" pattern="\d{16}" maxlength="16" placeholder="1234 5678 9012 3456" required>

                    <label for="expiry">Expiry Date</label>
                    <input type="month" name="expiry" id="expiry" required><br>

                    <label for="cvv">CVV</label>
                    <input type="number" name="cvv" id="cvv" maxlength="3" required>

                    <button type="submit">Pay Now</button>
                </form>

            </div>
        </div>
    </main>

    <?php include 'footer.php'; ?>
    
</body>
</html>
