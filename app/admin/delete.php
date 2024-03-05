<?php
include 'config.php';

if (isset($_GET['id'])) {
    $productId = mysqli_real_escape_string($connect, $_GET['id']);

    // Assuming 'products' is your table name
    $deleteQuery = "DELETE FROM products WHERE id = '$productId'";
    $result = mysqli_query($connect, $deleteQuery);

    if ($result) {
        echo "Product deleted successfully!";
    } else {
        echo "Error deleting product: " . mysqli_error($connect);
    }
} else {
    echo "Invalid product ID";
}
header("location: products.php");
?>
