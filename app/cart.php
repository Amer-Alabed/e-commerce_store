<?php
include 'config.php';
session_start();
$user_id = $_SESSION['user_id'];

// if(isset($_POST['submit'])){
//     $email = mysqli_real_escape_string($connect, $_POST['email']);
//     $pass = mysqli_real_escape_string($connect, md5($_POST['password']));

//     $select = mysqli_query($connect, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'") or die('query failed');

//     if(mysqli_num_rows($select) > 0){
//         $row = mysqli_fetch_assoc($select);
//         $_SESSION['user_id'] = $row['id'];
//         header('location: index.php');
//         exit();
//     } else {
//         $message[] = 'Incorrect password or email!';
//     }
// }
if(isset($_POST['add_to_cart'])){

   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
   $product_quantity = $_POST['product_quantity'];

   $select_cart = mysqli_query($connect, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

   if(mysqli_num_rows($select_cart) > 0){
      $message[] = 'The product has been added to the shopping cart!';
   }else{
      mysqli_query($connect, "INSERT INTO `cart`(user_id, name, price, image, quantity) VALUES('$user_id', '$product_name', '$product_price', '$product_image', '$product_quantity')") or die('query failed');
      $message[] = 'The product is added to the shopping cart!';
   }

};
if(isset($_POST['update_cart'])){
   $update_quantity = $_POST['cart_quantity'];
   $update_id = $_POST['cart_id'];
   mysqli_query($connect, "UPDATE `cart` SET quantity = '$update_quantity' WHERE id = '$update_id'") or die('query failed');
   $message[] = 'The shopping cart quantity has been updated successfully!';
}

// Redirect to login page if the user is not logged in
if(!isset($_SESSION['user_id'])){
    header('location: login.php');
    exit();
}
if(isset($_GET['remove'])){
   $remove_id = $_GET['remove'];
   mysqli_query($connect, "DELETE FROM `cart` WHERE id = '$remove_id'") or die('query failed');
   header('location:index.php');
}

// Logout logic
if(isset($_GET['logout'])){
    unset($_SESSION['user_id']);
    session_destroy();
    header('location: login.php');
    exit();
}
if(isset($_GET['delete_all'])){
   mysqli_query($connect, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
   header('location:index.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <title>cart</title>
</head>
<body>
    
<div class="shopping-cart">
   <h1 class="heading">Cart Shopping</h1>
<table>
   <thead>
      <th>Product Image</th>
      <th>Product Name</th>
      <th>Product Price</th>
      <th>quantity</th>
      <th>total price</th>
      <th>Delete Product</th>
   </thead>
      <tbody>
      <?php
         $cart_query = mysqli_query($connect, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
         $grand_total = 0;
         if(mysqli_num_rows($cart_query) > 0){
            while($fetch_cart = mysqli_fetch_assoc($cart_query)){
      ?>
         <tr>
            <td><img src="admin/<?php echo $fetch_cart['image']; ?>" height="75" alt=""></td>
            <td><?php echo $fetch_cart['name']; ?></td>
            <td><?php echo $fetch_cart['price']; ?>$ </td>
            <td>
               <form action="" method="post">
                  <input type="hidden" name="cart_id" value="<?php echo $fetch_cart['id']; ?>">
                  <input type="number" min="1" name="cart_quantity" value="<?php echo $fetch_cart['quantity']; ?>">
                  <input type="submit" name="update_cart" value="Edit" class="option-btn">
               </form>
            </td>
            <td><?php echo $sub_total = ($fetch_cart['price'] * $fetch_cart['quantity']); ?>$</td>
            <td><a href="index.php?remove=<?php echo $fetch_cart['id']; ?>" class="delete-btn">Remove</a></td>
         </tr>
      <?php
         $grand_total += $sub_total;
            }
         }else{
            echo '<tr><td style="padding:20px; text-transform:capitalize;" colspan="6">cart empty</td></tr>';
         }
      ?>
      <tr class="table-bottom">
         <td colspan="4">Total price:</td>
         <td><?php echo $grand_total; ?>$</td>
         <td><a href="index.php?delete_all" class="delete-btn <?php echo ($grand_total > 1)?'':'disabled'; ?>">Delete all</a></td>
      </tr>
   </tbody>
</table>



</div>

</div>
<p><a href="index.php">Go to products</a></p>
</body>
</html>