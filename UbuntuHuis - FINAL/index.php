<?php

session_start();
$pageType = 'index'; // For index.php
include 'header.php';

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubuntu Huis</title>
    <link rel = "stylesheet" href = "style.css">

    <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-04P6ZYYS4W"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-04P6ZYYS4W');
</script>

<!-- ✅ Bootstrap CDN -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> -->

</head>
<body>

    <section id = "banner">
        <h2>Howzit Mzansi!</h2>
        <p>
        <h3>Shop the best products <br> and great services</h3>
        <h4>...and always remember, <span class = "highlight">local is lekker!</span></h4>
        </p>
        <!-- <button>Discover more</button> -->
    </section><br><br><br>

    <section id = "categories" class = "section-p1">

        <div class = "container">
            <a href = "login.php">
            <img src = "categ1.jpg" alt = "">
            <h5>Artisan and Handmade Products</h5>
            </a>
        </div>

        <div class = "container">
            <a href = "login.php">
            <img src = "categ2.jpg" alt = "">
            <h5>Food and Produce</h5>
            </a>
        </div>

        <div class = "container">
            <a href = "login.php">
            <img src = "categ3.jpg" alt = "">
            <h5>Thrift and Secondhand</h5>
            </a>
        </div>

        <div class = "container">
            <a href = "login.php">
            <img src = "categ4.jpg" alt = "">
            <h5>Services</h5>
            </a>
        </div>

        <div class = "container">
            <a href = "login.php">
            <img src = "categ5.jpg" alt = "">
            <h5>Rentals</h5>
            </a>
        </div>
    </section>

    <section id = "area" class = "section-a1">

        <h4>Find by provinces</h4>
        <div class = "areaP">
            <a href = "login.php"><button>Eastern Cape</button></a>
            <a href = "login.php"><button>Free State</button></a>
            <a href = "login.php"><button>Gauteng</button></a>
            <a href = "login.php"><button>Kwa-Zulu Natal</button></a>
            <a href = "login.php"><button>Limpopo</button></a>
            <a href = "login.php"><button>Mpumalanga</button></a>
            <a href = "login.php"><button>Northern Cape</button></a>
            <a href = "login.php"><button>North West</button></a>
            <a href = "login.php"><button>Western Cape</button></a>
        </div>

        <h4>Find by main Cities</h4>
        <div class = "areaC">
            <a href = "login.php"><button>Bhisho</button></a>
            <a href = "login.php"><button>Bloemfontein</button></a>
            <a href = "login.php"><button>Cape Town</button></a>
            <a href = "login.php"><button>Johannesburg</button></a>
            <a href = "login.php"><button>Kimberly</button></a>
            <a href = "login.php"><button>Mahikeng</button></a>
            <a href = "login.php"><button>Mbombela</button></a>
            <a href = "login.php"><button>Pietermaritzburg</button></a>
            <a href = "login.php"><button>Polokwane</button></a>
        </div>
    </section>

    <script src = "index.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <?php include 'footer.php'; ?>

</body>
</html>