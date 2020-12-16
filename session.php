<?php
session_start();
include('dbconnect.php');


   $user_check = $_SESSION['login_user'];

   $ses_sql = mysqli_query($db,"SELECT us_username FROM tbl_user WHERE us_username = '$user_check' ");

   $row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);

   $login_session = $row['us_username'];

   if(!isset($_SESSION['login_user'])){
      header("location:login.php");
   }
?>
