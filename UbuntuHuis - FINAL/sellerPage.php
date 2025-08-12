<?php

session_start();
require_once 'config.php';
$pageType = 'seller'; 

if (!isset($_SESSION['email']) || !isset($_SESSION['name'])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION['role'] !== 'seller') {
    echo "Access denied.";
    exit();
}

$welcomeMsg = false;
$welcomeMessage = '';

if (isset($_SESSION['welcome_msg']) && $_SESSION['welcome_msg'] === true) {
    $welcomeMsg = true;
    $welcomeMessage = "Welcome, " . $_SESSION['name'] . " to Ubuntu Huis! You are logged in as " . $_SESSION['role'] . ".";
    $_SESSION['welcome_msg'] = false; 
}

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

//Filtering the category of products added by the sellers
$category = $_GET['category'] ?? '';
$province = $_GET['province'] ?? '';
$city = $_GET['city'] ?? '';

$sql = "SELECT * FROM products WHERE 1=1";
$parameters = [];
$type = '';

if ($category) {
    $sql .= " AND category = ?";
    $parameters[] = $category;
    $type .= 's';
}
if ($province) {
    $sql .= " AND province = ?";
    $parameters[] = $province;
    $type .= 's';
}
if ($city) {
    $sql .= " AND city = ?";
    $parameters[] = $city;
    $type .= 's';
}

$stmt = $conn->prepare($sql);
if (!empty($parameters)) {
    $stmt->bind_param($type, ...$parameters);
}
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Page</title>
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

    <section id = "banner">
        <h2>Howzit Mzansi!</h2>
        <p>
        <h3>Shop the best products <br> and great services</h3>
        <h4>...and always remember, <span class = "highlight">local is lekker!</span></h4>
        </p>
        <!-- <button>Discover more</button> -->
    </section>

    <section id = "categories" class = "section-p1">

        <div class = "container">
            <a href = "viewProducts.php?category=Artisan and Handmade Products">
            <img src = "categ1.jpg" alt = "">
            <h5>Artisan and Handmade Products</h5>
            </a>
        </div>

        <div class = "container">
            <a href = "viewProducts.php?category=Food and Produce">
            <img src = "categ2.jpg" alt = "">
            <h5>Food and Produce</h5>
            </a>
        </div>

        <div class = "container">
            <a href = "viewProducts.php?category=Thrift and Secondhand">
            <img src = "categ3.jpg" alt = "">
            <h5>Thrift and Secondhand</h5>
            </a>
        </div>

        <div class = "container">
            <a href = "viewProducts.php?category=Services">
            <img src = "categ4.jpg" alt = "">
            <h5>Services</h5>
            </a>
        </div>

        <div class = "container">
            <a href = "viewProducts.php?category=Rentals">
            <img src = "categ5.jpg" alt = "">
            <h5>Rentals</h5>
            </a>
        </div>
    </section>

    <section id = "area" class = "section-a1">

        <h4>Find by provinces</h4>
        <div class = "areaP">
            <a href = "viewProducts.php?province=Eastern Cape"><button>Eastern Cape</button></a>
            <a href = "viewProducts.php?province=Free State"><button>Free State</button></a>
            <a href = "viewProducts.php?province=Gauteng"><button>Gauteng</button></a>
            <a href = "viewProducts.php?province=Kwa-Zulu Natal"><button>Kwa-Zulu Natal</button></a>
            <a href = "viewProducts.php?province=Limpopo"><button>Limpopo</button></a>
            <a href = "viewProducts.php?province=Mpumalanga"><button>Mpumalanga</button></a>
            <a href = "viewProducts.php?province=Northern Cape"><button>Northern Cape</button></a>
            <a href = "viewProducts.php?province=North West"><button>North West</button></a>
            <a href = "viewProducts.php?province=Western Cape"><button>Western Cape</button></a>
        </div>

        <h4>Find by main Cities</h4>
        <div class = "areaC">
            <a href = "viewProducts.php?city=Bhisho"><button>Bhisho</button></a>
            <a href = "viewProducts.php?city=Bloemfontein"><button>Bloemfontein</button></a>
            <a href = "viewProducts.php?city=Cape Town"><button>Cape Town</button></a>
            <a href = "viewProducts.php?city=Johannesburg"><button>Johannesburg</button></a>
            <a href = "viewProducts.php?city=Kimberly"><button>Kimberly</button></a>
            <a href = "viewProducts.php?city=Mahikeng"><button>Mahikeng</button></a>
            <a href = "viewProducts.php?city=Mbombela"><button>Mbombela</button></a>
            <a href = "viewProducts.php?city=Pietermaritzburg"><button>Pietermaritzburg</button></a>
            <a href = "viewProducts.php?city=Polokwane"><button>Polokwane</button></a>
        </div>
    </section>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <?php include 'footer.php'; ?>

</body>
</html>