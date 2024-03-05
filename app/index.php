<?php
include 'config.php';
session_start();
$user_id = $_SESSION['user_id'];

if(isset($_POST['submit'])){
    $email = mysqli_real_escape_string($connect, $_POST['email']);
    $pass = mysqli_real_escape_string($connect, md5($_POST['password']));

    $select = mysqli_query($connect, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'") or die('query failed');

    if(mysqli_num_rows($select) > 0){
        $row = mysqli_fetch_assoc($select);
        $_SESSION['user_id'] = $row['id'];
        header('location: index.php');
        exit();
    } else {
        $message[] = 'Incorrect password or email!';
    }
}
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
   header('location:cart.php');
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
   header('location:cart.php');
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>shopping cart</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/styles.css">

</head>
<body>
   
   <?php
   if(isset($message)){
      foreach($message as $message){
       echo '<div class="message" onclick="this.remove();">'.$message.'</div>';
      }
   }
   ?>

   <div class="container">
      <div class="user-profile">
         <?php
          $select_user = mysqli_query($connect, "SELECT * FROM `users` WHERE id = '$user_id'") or die('query failed');
            if(mysqli_num_rows($select_user) > 0){
                $fetch_user = mysqli_fetch_assoc($select_user);
             };
          ?>
         <p>Username : <span><?php echo $fetch_user['name']; ?></span> </p>
         <div class="flex">
          <a href="index.php?logout=<?php echo $user_id; ?>" class="delete-btn">Logout</a>
         </div>
      </div>
   </div>

      <div class="products">
         <h1 class="heading">Products</h1>
      <div class="box-container">
   <?php
   include('config.php');
      $result = mysqli_query($connect, "SELECT * FROM products");      
      while($row = mysqli_fetch_array($result)){
   ?>
      <form method="post" class="box" action="">
         <img src="admin/<?php echo $row['image']; ?>"  width="200">
         <div class="name"><?php echo $row['name']; ?></div>
         <div class="price"><?php echo $row['price']; ?></div>
         <input type="number" min="1" name="product_quantity" value="1">
         <input type="hidden" name="product_image" value="<?php echo $row['image']; ?>">
         <input type="hidden" name="product_name" value="<?php echo $row['name']; ?>">
         <input type="hidden" name="product_price" value="<?php echo $row['price']; ?>">
         <input type="submit" value="add to cart" name="add_to_cart" class="btn">
      </form>
      <?php
      };
      ?>
   </div>
</div>
<p><a href="cart.php">Going to cart</a></p>
</body>
</html>