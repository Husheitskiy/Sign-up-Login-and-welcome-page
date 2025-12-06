<?php
$success=0;
$user=0;

if($_SERVER['REQUEST_METHOD']=='POST'){
    include 'connect.php';
    $username=$_POST['username'];
    $password=$_POST['password'];

    $sql="Select * from `registration` where username='$username' and password='$password'";

    $result=mysqli_query($con,$sql);
    if($result){
        $num=mysqli_num_rows($result);
        if($num>0){
            $user=1;
            session_start();
            $_SESSION['username']=$username;
            header('location:home.php');
        }else{
              $user=0;
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
    <?php
if($user){
echo "<div class=\"alert alert-success\" role=\"alert\">
  Successfully Log In
</div>";
}else{
    echo "<div class=\"alert alert-danger\" role=\"alert\">
  Wrong Username or Password!
</div>";
}
?>

    <header>
        <h1>Log In to our website</h1>
    </header>
    <form class="body1" method="post">
        <div class="username-parent">
            <div class="uslabel">Username</div>
            <input class="ustf" id="ustf" name="username" required/>
        </div>
        <div class="ps-parent">
            <div class="pslabel">Password</div>
            <input class="pstf" id="pstf" name="password" required/>
        </div>
        <button class="signupBtn" id="signupBtn" type="submit">Log In</button>

</form>
</body>
</html>

