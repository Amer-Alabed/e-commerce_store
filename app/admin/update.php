<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Update Product</title>
</head>
<body>
    <?php
    include 'config.php';
    $ID = $_GET["id"];
    $UP = mysqli_query($connect, "SELECT * from products where id = $ID");
    $date = mysqli_fetch_array($UP);
    ?>
    <div class="container">
        <form action="up.php" method="post" enctype="multipart/form-data">
            <h2>Page Update Product</h2>
            <input type="text" name="id" placeholder="Name Your ID" value="<?PHP echo $date['id']?>">
            <input type="text" name="name" placeholder="Name Your Product" value="<?PHP echo $date['name'] ?>">
            <input type="text" name="price" placeholder="Price Your Product" value="<?PHP echo $date['price'] ?>">
            <label for="file">Update Image</label>
            <input type="file" name="image" id="file" style="display: none;">
            <button name="update" type="submit">Update Product</button>
            <a class="a" href="products.php">Place For Products</a>
            <b>Developer for AMER ALABED</b>
        </form>
    </div>
</body>
</html>