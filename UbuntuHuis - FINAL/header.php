<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($pageType)) {
    $pageType = ''; // or default to 'index' if that's preferred
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubuntu Huis</title>

    <!-- ✅ Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background-color:white;
            padding-top: 150px;
            color: #333;
            height:100%;
        }

        header {
            height: 100px;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            padding: 20px 100px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: #E0DCD0;
            color: #c1b385;
            backdrop-filter: blur(10px);
            z-index: 999;
        }

        .navigation a {
            position: relative;
            font-size: 1.1em;
            color: #c1b385;
            text-decoration: none;
            font-weight: 500;
            margin-left: 40px;
        }

        .navigation a::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -2px;
            width: 100%;
            height: 2px;
            background: #fff;
            border-radius: 5px;
            transform: scaleX(0);
            transition: transform .5s;
        }

        .navigation a:hover::after {
            transform: scaleX(1);
        }

        .icon-enlarge {
            font-size: 21.5px;
        }

        @media (max-width: 768px) {
            header {
                flex-direction: column;
                align-items: flex-start;
                padding: 10px 20px;
                height: auto;
            }

            header h1 {
                font-size: 1.5em;
                margin-bottom: 8px;
            }

            .navigation {
                display: flex;
                flex-direction: row;
                gap: 20px;
                overflow-x: auto;
                white-space: nowrap;
                width: 100%;
                padding-bottom: 5px;
                scrollbar-width: none;
            }
            .navigation::-webkit-scrollbar { display: none; }

            .navigation a {
                flex: 0 0 auto;
                margin-left: 0;
                font-size: 1em;
                padding: 6px 10px;
            }

            .icon-enlarge,
            .navigation ion-icon {
                font-size: 20px;
                height: 22px;
            }
            }

    </style>
</head>
<body>
    <header>
        <h1>Ubuntu Huis</h1>

        <nav class="navigation">
            <?php
            $homeLink = 'index.php';
            if (isset($_SESSION['role'])) {
                if ($_SESSION['role'] === 'seller') {
                    $homeLink = 'sellerPage.php';
                } elseif ($_SESSION['role'] === 'buyer') {
                    $homeLink = 'buyerPage.php';
                }
            }
            // // Dynamic Header Menu based on Page Type
            // // Dynamic Header Menu based on Page Type
            if ($pageType === 'index') {
                echo '<a href="index.php">Home</a>';
                echo '<a href="about.php">About</a>';
                echo '<a href="help.php">Help</a>';
                echo '<a href="login.php"><ion-icon class="icon-enlarge" name="cart"></ion-icon></a>';
                echo '<a href="login.php"><ion-icon class="icon-enlarge" name="person-sharp"></ion-icon></a>';
            } elseif ($pageType === 'buyer') {
                echo '<a href="' . $homeLink . '">Home</a>';
                echo '<a href="about.php">About</a>';
                echo '<a href="help.php">Help</a>';
                echo '<a href="checkCart.php"><ion-icon class="icon-enlarge" name="cart"></ion-icon></a>';
            } elseif ($pageType === 'seller') {
                echo '<a href="' . $homeLink . '">Home</a>';
                echo '<a href="about.php">About</a>';
                echo '<a href="help.php">Help</a>';
                echo '<a href="checkCart.php"><ion-icon class="icon-enlarge" name="cart"></ion-icon></a>';
                echo '<a href="addProduct.php"><ion-icon class="icon-enlarge" name="add-circle"></ion-icon></a>';
                echo '<a href="createProfile.php"><ion-icon name="person-circle"></ion-icon></a>';
            }else {
                echo '<a href="' . $homeLink . '">Home</a>';
                echo '<a href="about.php">About</a>';
                echo '<a href="help.php">Help</a>';
            }

            ?>
        </nav>
    </header>

    <script src = "index.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

</body>
</html>
