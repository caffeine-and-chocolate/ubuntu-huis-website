<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Payment Success</title>
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

.success-box {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  min-height: calc(100vh - 100px); /* accounting for header height */
  text-align: center;
  padding: 20px;
}

    /* a {
      margin-top: 20px;
      display: inline-block;
      text-decoration: none;
      background: #007bff;
      color: white;
      padding: 10px 20px;
      border-radius: 6px;
    }
    a:hover {
      background: #0056b3;
    } */
  </style>
</head>
<body>

    <?php include 'header.php'; ?>
    
  <div class="success-box">
    <h1>✅ Payment Successful!</h1>
    <p>Thank you for your purchase.</p>
    <a href="purchaseHistory.php">View My Products</a>
  </div>

  <?php include 'footer.php'; ?>
    
</body>
</html>