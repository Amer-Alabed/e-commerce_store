<?php

include 'config.php';

if(isset($_POST['submit'])){

   $name = mysqli_real_escape_string($connect, $_POST['name']);
   $email = mysqli_real_escape_string($connect, $_POST['email']);
   $pass = mysqli_real_escape_string($connect, md5($_POST['password']));
   $cpass = mysqli_real_escape_string($connect, md5($_POST['cpassword']));

   $select = mysqli_query($connect, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'") or die('query failed');

   if(mysqli_num_rows($select) > 0){
      $message[] = 'user already exist!';
   }else{
      mysqli_query($connect, "INSERT INTO `users`(name, email, password) VALUES('$name', '$email', '$pass')") or die('query failed');
      $message[] = 'registered successfully!';
      header('location:login.php');
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Register</title>
   <link rel="stylesheet" href="css/styles.css">
   <style>
      input{
         text-align: center;
      }
   </style>
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

   <form action="" method="post">
      <h2>Creat New Account</h2>
      <input type="text" name="name" required placeholder="Username" class="box">
      <input type="email" name="email" required placeholder="Email" class="box">
      <input type="password" name="password" required placeholder="Password" class="box">
      <input type="password" name="cpassword" required placeholder="Confirm" class="box">
      <input type="submit" name="submit" class="btn" value="Register">
      <p>Do you have account <a href="login.php"> Login</a></p>
   </form>

</div>

</body>
</html>