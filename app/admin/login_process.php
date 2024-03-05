<?php
include 'config.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($connect, $_POST['username']);
    $password = mysqli_real_escape_string($connect, md5($_POST['password']));

    // استعلام SQL لاسترجاع اسم المستخدم وكلمة المرور من جدول المشرفين
    $query = "SELECT * FROM `admins` WHERE username='$username' AND password='$password'";
    $result = mysqli_query($connect, $query);

    if (mysqli_num_rows($result) == 1) {
        // تم العثور على مشرف بنفس اسم المستخدم وكلمة المرور
        $_SESSION["admin_logged_in"] = true;
        header("Location: index.php");
        exit;
    } else { 
        $error_message = "Invalid username or password. Please try again.";
    }
}
?>
