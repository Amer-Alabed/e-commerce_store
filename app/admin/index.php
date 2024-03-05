<?php
session_start();

if (!isset($_SESSION["admin_logged_in"]) || $_SESSION["admin_logged_in"] !== true) {
    header("Location: login.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Admin Dashboard | Upload Product</title>
</head>
<body>
    <h2>Welcome, Admin!</h2>
    <p>This is the admin dashboard.</p>
    <a href="logout.php">Logout</a>
    <div class="container">
        <form action="insert.php" method="post" enctype="multipart/form-data">
            <h2>Page Upload Product</h2>
            <img src="logo.jpg" alt="LOGO" width="500px">
            <input type="text" name="name" placeholder="Name Your Product" required>
            <input type="text" name="price" placeholder="Price Your Product" required>
            <label for="file">choose Image</label>
            <input type="file" name="image" id="file" style="display: none;" required>
            <button name="upload">Upload Product</button>
            <a href="products.php">Place For Products</a>
        </form>
        <p>Developer for AMER ALABED</p>
    </div>
</body>
</html>