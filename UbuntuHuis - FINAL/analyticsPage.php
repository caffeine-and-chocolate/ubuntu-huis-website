<?php
session_start();

// Optional: Check if user is seller or admin
if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['seller', 'admin'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Analytics Dashboard</title>

  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 40px;
      background-color: #f4f4f4;
      text-align: center;
    }

    iframe {
      border: 1px solid #ccc;
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    h1 {
      margin-bottom: 30px;
      color: #333;
    }
  </style>
</head>
<body>

    <?php include 'header.php'; ?>

  <h1>Website Analytics Dashboard</h1>
  <iframe
    width="1000"
    height="600"
    src="https://lookerstudio.google.com/embed/reporting/b38cef4e-0ab1-4b78-a2ec-e508a29dc757/page/D03NF"
    frameborder="0"
    style="border:0"
    allowfullscreen
    sandbox="allow-storage-access-by-user-activation allow-scripts allow-same-origin allow-popups allow-popups-to-escape-sandbox">
  </iframe><br><br><br>

  <a href="https://analytics.google.com/analytics/web/#/p493252262/reports/intelligenthome" target="_blank" rel="noopener noreferrer">View Detailed Analytics here</a>


  <?php include 'footer.php'; ?>
    
</body>
</html>
