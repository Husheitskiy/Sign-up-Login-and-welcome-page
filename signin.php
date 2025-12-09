<?php
session_start();

$success=0;
$user=0;
$showmessage=0;

if($_SERVER['REQUEST_METHOD']=='POST'){
    include 'connect.php';
    $username=$_POST['username'];
    $password=$_POST['password'];
    $sql="SELECT * from `registration` WHERE username='$username' and password='$password'";
    $result=mysqli_query($con,$sql);
    if($result){
        $num=mysqli_num_rows($result);
        if($num>0){
            $row=mysqli_fetch_assoc($result);//give row all info
            $showmessage=1;
            $success=1;
            $_SESSION['user_id']=$row['id'];
            $_SESSION['username']=$row['username'];
            header('location:home.php'); 
            exit();
        }else{
            $success=0;
            $showmessage=1;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php 
    if($success && $showmessage){
         echo '<div class=\"alert alert-success\" role=\"alert\">
         Sign In Successful!
         </div>';
    }else if(!$success && $showmessage){
                 echo '<div class=\"alert alert-danger\" role=\"alert\">
         User Already Exist!
         </div>';
    }
     ?>

<header>
    <h1>Sign In</h1>
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

    <button class="signupBtn" type="submit">Sign In</button>

    <p style="text-align:center; margin-top:20px;">
        Already have an account? <a href="login.php">Login here</a>
    </p>

</form>

</body>
</html>
