<?php
// ✅ ADD session_start() at the VERY TOP
session_start();

$success=0;
$user=0;

if($_SERVER['REQUEST_METHOD']=='POST'){
    include 'connect.php';
    $username=$_POST['username'];
    $password=$_POST['password'];

    $sql="Select * from `registration` where username='$username'";
    $result=mysqli_query($con,$sql);
    if($result){
        $num=mysqli_num_rows($result);
        if($num>0){
            $user=1;
        }else{
            $sql="insert into `registration`(username,password) values('$username','$password')";
            $result1=mysqli_query($con,$sql);

            if($result1){
                $user_id = mysqli_insert_id($con);
                $success=1;
                
                // ✅ Already started session at top
                $_SESSION['username']=$username;
                $_SESSION['user_id'] = $user_id;
                
                // ✅ ADD exit() after header redirect
                header('location:home.php');
                exit(); // ⭐⭐⭐ THIS IS WHAT'S MISSING! ⭐⭐⭐
                
            }else{
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
    if($user){
        echo "<div class=\"alert alert-danger\" role=\"alert\">
          User already exists!
        </div>";
    }
    if($success){
        echo '<div class="alert alert-success" role="alert">
        Sign up successful!
        </div>';
    }
    ?>

    <header>
        <h1>Sign up</h1>
    </header>
    <form class="body1" method="post">
        <div class="username-parent">
            <div class="uslabel">Username</div>
            <input class="ustf" name="username" required/>
        </div>
        <div class="ps-parent">
            <div class="pslabel">Password</div>
            <input type="password" class="pstf" name="password" required/> <!-- Added type="password" -->
        </div>
        <button class="signupBtn" type="submit">Sign Up</button>
        <p style="text-align:center; margin-top:20px;">
            Already have an account? <a href="login.php">Login here</a>
        </p>
    </form>
</body>
</html>