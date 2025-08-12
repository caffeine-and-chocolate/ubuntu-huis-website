<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // ========== Registration ==========
    if (isset($_POST['register'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $role = $_POST['role'];

        // Validate all required fields
        if (empty($name) || empty($email) || empty($_POST['password']) || empty($role)) {
            $_SESSION['register_error'] = 'Please fill in all registration fields.';
            $_SESSION['active_form'] = 'register';
            header("Location: login.php");
            exit();
        }

        // Check if email already exists
        $stmt = $conn->prepare("SELECT email FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $_SESSION['register_error'] = 'Email is already registered!';
            $_SESSION['active_form'] = 'register';
            header("Location: login.php");
            exit();
        } else {
            $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $name, $email, $password, $role);
            $stmt->execute();
            $_SESSION['register_success'] = 'Registration successful! You can now log in.';
            header("Location: login.php");
            exit();
        }
    }

    // ========== Login ==========
    if (isset($_POST['login'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $role = $_POST['role'];

        if (empty($email) || empty($password) || empty($role)) {
            $_SESSION['login_error'] = 'Please fill in all login fields.';
            $_SESSION['active_form'] = 'login';
            header("Location: login.php");
            exit();
        }

        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND role = ?");
        $stmt->bind_param("ss", $email, $role);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            if ($user && $user['blocked']) {
                echo "<script>alert('Your account has been blocked. Please contact support at lesediadm@gmail.com or at 072 272 7722.'); window.location.href='login.php';</script>";
                exit();
            }

            if (password_verify($password, $user['password']) && $user['role'] === $role) {
                $_SESSION['name'] = $user['name'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['welcome_msg'] = true;

                if ($user['role'] === 'admin') {
                    header("Location: adminPage.php");
                } elseif ($user['role'] === 'seller') {
                    header("Location: sellerPage.php");
                } else {
                    header("Location: buyerPage.php");
                }
                exit();
            }
        }

        $_SESSION['login_error'] = 'Incorrect email, password or role';
        $_SESSION['active_form'] = 'login';
        header("Location: login.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login/Register</title>

    <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-04P6ZYYS4W"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-04P6ZYYS4W');
</script>

</head>
<body>
    <?php include 'header.php'; ?>

    <?php include 'footer.php'; ?>
    
</body>
</html>