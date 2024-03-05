<?php
include "config.php";

if(isset($_POST['update'])){
    // Assuming your price is a numeric value
    $ID = mysqli_real_escape_string($connect, $_POST["id"]);
    $NAME = mysqli_real_escape_string($connect, $_POST["name"]);
    $PRICE = (float)$_POST["price"];
    $IMAGE = $_FILES["image"];

    // Assuming 'image' is a file upload
    $image_location = $_FILES['image']['tmp_name'];
    $image_name = mysqli_real_escape_string($connect, $_FILES['image']['name']);
    if(move_uploaded_file($image_location, "images/".$image_name)){
        echo "<script>alert('done')</script>";
    } else {
        echo "<script>alert('not done')</script>";
    }
    
    $image_up = "images/$image_name";

    $update = "UPDATE products SET name = '$NAME', price = '$PRICE', image = '$image_up' where id = $ID ";
    
    mysqli_query($connect, $update);
    header("location: products.php");
}
?>
