<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<style>
    html, body {
        height: 100%;
        margin: 0;
        display: flex;
        flex-direction: column;
    }

    main {
        flex: 1;
    }

    #footer {
        margin-top: auto;
        width: 100%;
        color: #c1b385;
        text-align: center;
        padding: 1rem 0;
    }

    #footer a {
        color: #c1b385;
        text-decoration: none;
    }

    #footer a:hover {
        text-decoration: underline;
    }
</style>

<footer id="footer">
    <p class="mb-1">&copy; <?php echo date('Y'); ?> All Copyrights Reserved | Ubuntu Huis.</p>
    <a href="logout.php">Logout</a>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
