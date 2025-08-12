<?php 

session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel = "stylesheet" href = "style.css">

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
</style>

</head>
<body>

     <?php include 'header.php'; ?>
    
     <div class = "wrapper">

            <span class = "icon-close"><ion-icon name="close"></ion-icon></span>

            <!-- Login Form -->
            <div class = "form-box login">
                <h2>Login</h2>

                <?php
                if (isset($_SESSION['login_error'])) {
                    echo '<div class="errorMessage">' . $_SESSION['login_error'] . '</div>';
                    unset($_SESSION['login_error']);
                }
                ?>

                <form action = "login_register.php" method = "post">

                    <div class = "input-box">
                        <span class = "icon">
                            <ion-icon name="mail"></ion-icon>
                        </span>
                        <input type = "email" name = "email" required>
                        <label>Email</label>
                    </div>

                    <div class = "input-box">
                        <span class = "icon">
                            <ion-icon name="lock-closed"></ion-icon>
                        </span>
                        <input type = "password" name = "password" required>
                        <label>Password</label>
                    </div>

                    <div class="role-select">
                        <label for="role-login">Login as:</label>
                        <select name = "role" id="role-login" required>
                            <option value="">Select Role</option>
                            <option value="buyer">Buyer</option>
                            <option value="seller">Seller</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>

                    <button type = "submit" name = "login" class = "btn">Login</button>

                    <div class="login-register">
                        <p>Don't have an account? <a href = "#" class = "register-link">Register</a></p>
                    </div>
                </form>
            </div>


            <!-- Register Form -->
             <div class = "form-box register">
                <h2>Register</h2>

                <?php
                if (isset($_SESSION['register_error'])) {
                    echo '<div class="errorMessage">' . $_SESSION['register_error'] . '</div>';
                    unset($_SESSION['register_error']);
                }
                ?>

                <form action = "login_register.php" method = "post">

                    <div class = "input-box">
                        <span class = "icon">
                            <ion-icon name="person"></ion-icon>
                        </span>
                        <input type = "text" name = "name" required>
                        <label>Username</label>
                    </div>

                    <div class = "input-box">
                        <span class = "icon">
                            <ion-icon name="mail"></ion-icon>
                        </span>
                        <input type = "email" name = "email" required>
                        <label>Email</label>
                    </div>
                    <div class = "input-box">
                        <span class = "icon">
                            <ion-icon name="lock-closed"></ion-icon>
                        </span>
                        <input type = "password" name = "password" required>
                        <label>Password</label>
                    </div>

                    <div class="role-select">
                        <label for="role-register">Register as:</label>
                        <select id="role-register" name = "role" required>
                            <option value="">Select Role</option>
                            <option value="buyer">Buyer</option>
                            <option value="seller">Seller</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>

                    <div class = "remember-forgot">
                        <label><input type = "checkbox" required>I agree to the terms & conditions</label>
                    </div>

                    <button type = "submit" name = "register" class = "btn">Register</button>

                    <div class = "login-register">
                        <p>Already have an account? <a href = "#" class = "login-link">Login</a></p>
                    </div>
                    
                </form>
            </div>
        </div>

    <script src = "index.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <?php include 'footer.php'; ?>
    
</body>
</html>
