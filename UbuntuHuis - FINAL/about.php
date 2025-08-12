<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

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
    padding: 90px 60px; 
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
    
    <p>This project aims to develop a C-2-C e-commerce platform that empowers the informal economy of South Africa<br>
        by ensuring that it is included while also contributing to the country’s economy by ensuring that the money stays<br>
        within the country. By creating a South African based C-2-C e-commerce platform, we not only take advantage of the <br>
        growth the e-commerce market is predicted to have in the coming years but also ensure that South African consumers <br>
        continue with their e-commerce activities while contributing to the country’s economy. <br><br>

        The inclusion of the informal economy helps South Africans empower themselves and provide services or products and<br> 
        be able to get revenue from their services or products. By creating a website that is easy to use, we create inclusivity<br> 
        and ensure that people across different ages can interact with the website. <br><br>

        With the e-commerce market showing tremendous growth in South Africa, the incorporation of the informal economy to that <br>
        while ensuring that the money stays within the country can lead to growth in the country’s economy.
    </p>

    <?php include 'footer.php'; ?>
    
</body>
</html>