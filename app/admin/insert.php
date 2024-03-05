<?php
include 'config.php';

if(isset($_POST['upload'])){
    // Assuming your price is a numeric value
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

    $insert = "INSERT INTO products (name, price, image) VALUES ('$NAME', '$PRICE', '$image_up')";
    

    mysqli_query($connect, $insert);
    header("location: index.php");
    exit();
}
?>
