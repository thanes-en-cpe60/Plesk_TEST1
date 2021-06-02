<?php
    require 'connectdb.php';
  
    
    // $user_id = mysqli_real_escape_string($conn,$_POST['user_id']);
    // $use_password = mysqli_real_escape_string($conn,$_POST['user_password']);
    $user_id= 'admin';
    $use_password ='admin';

    // $salt = 'tikde78uj4ujuhlaoikiksakeidke';
    // $hash_use_password = hash_hmac('sha256', $use_password, $salt);
    
    $sql = "SELECT * FROM user WHERE user_id=? AND use_password=?";
    $row = mysql_fetch_array($sql);
    if ($row['user_id'] == $user_id && $row['use_password'] == $use_password) {
        header("Location: home.php");
    } else {
        header('Location: login.php?err=2');
    }