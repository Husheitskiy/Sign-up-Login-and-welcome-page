<?php
session_start();

$success=0;
$user=0;
$showmessage=0;

if($_SERVER['REQUEST_METHOD']=='POST'){
    include 'connect.php';
    $username=$_POST['username'];
    $password=$_POST['password'];
    $sql="SELECT * from `registration` WHERE username='$username'";
    $result=mysqli_query($con,$sql);
    if($result){
        $num=mysqli_num_rows($result);
        if($num>0){
            $user=1;
            $showmessage=1;
        }else{
            $sql= "INSERT INTO `registration` (username, password) VALUES('$username','$password')";
            $result=mysqli_query($con,$sql);
            if($result){
                $user_id=mysqli_insert_id($con);
                $showmessage=0;
                $success=1;
                $_SESSION['user_id']=$user_id;
                $_SESSION['username']=$username;
                header('location:home.php'); 
                exit();
            }else{
                $showmessage=0;
                $success=0;
                die(mysqli_error($con));
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php 
    if($user && $showmessage){
         echo '<div class=\"alert alert-danger\" role=\"alert\">
         User already exists!
         </div>';
    }
    if($success && $showmessage){
         echo '<div class=\"alert alert-success\" role=\"alert\">
         Sign Up Successful!
         </div>';
    }
     ?>

<header>
    <h1>Sign up</h1>
</header>

<form class="body1" method="POST">

    <div class="username-parent">
        <label class="uslabel">Username</label>
        <input type="text" class="ustf" name="username" required>
    </div>

    <div class="ps-parent">
        <label class="pslabel">Password</label>
        <input type="password" class="pstf" name="password" required>  
    </div>

    <button class="signupBtn" type="submit">Sign Up</button>

    <p style="text-align:center; margin-top:20px;">
        Already have an account? <a href="signin.php">Login here</a>
    </p>

</form>
</body>
</html>
