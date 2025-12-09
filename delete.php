<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('location: signin.php');
    exit();
}

include 'connect.php';
if(isset($_GET['delete_id'])){
    $pet_id=$_GET['delete_id'];
    $sql="DELETE FROM `pets` WHERE pet_id='$pet_id'";
    $result=mysqli_query($con,$sql);
    if($result){
        header('location:home.php'); 
        exit();
    }else{
        die(mysqli_errno($con));
    }
}
?>