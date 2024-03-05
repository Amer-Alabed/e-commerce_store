<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style_product.css">
    <title>Products</title>
</head>
<body>
    
<h2 style="text-align:center;">Page Products for Admin</h2>
 <div class='card-container'>
    <?php
    include 'config.php';

    $result = mysqli_query($connect, "SELECT * FROM products");

    while ($row = mysqli_fetch_assoc($result)) {
        echo "
            <div class='card'>
                <img src='{$row['image']}' alt='Card Image'>
                <div class='card-content'>
                    <h3>{$row['name']}</h3>
                    <p>{$row['price']}</p>
                    <a href='delete.php?id={$row['id']}'>DELETE</a>
                    <a href='update.php?id={$row['id']}'>UPDATE</a>
                </div>
            </div>
        ";
    }
    ?>
</div>
<p style="text-align: center;
    margin-top: 20px;
    font-weight: bold;G"
    >
    <a href="index.php" style = "text-decoration: none;color: #007BFF;">Go to add products</a>
</p>
</body>
</html>
