<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bank Transfer Page</title>
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
        /* body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background: #e6f0f5;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        } */

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
        main {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: calc(100vh - 100px); /* Full height minus fixed header */
            padding: 20px;
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

        .transfer-container {
            margin-top: 40px;
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

    </style>

</head>

<body>

    <?php include 'header.php'; ?>

    <main class="content">
        <div class="transfer-container">
            <h2>Bank Transfer Details</h2>
            <form action="processBankTransfer.php" method="POST">
                <label for="bankName">Bank Name</label>
                <input type="text" name="bankName" id="bankName" required>

                <label for="accountName">Account Name</label>
                <input type="text" name="accountName" id="accountName" required>

                <label for="accountNumber">Account Number</label>
                <input type="number" name="accountNumber" id="accountNumber" required>

                <label for="branchCode">Branch Code (optional)</label>
                <input type="text" name="branchCode" id="branchCode">

                <label for="reference">Payment Reference</label>
                <input type="text" name="reference" id="reference" required>

                <button type="submit">Submit Transfer Info</button>
                <div class="note">Make sure the details are correct before submission.</div>
            </form>
        </div>
    </main>

    <?php include 'footer.php'; ?>
    
</body>
</html>