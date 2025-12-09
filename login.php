<?php
// ✅ Add at top
session_start();

// ✅ ADD DEBUG OUTPUT
echo "<div style='background:#ffeb3b; padding:15px; margin:10px; border:2px solid orange;'>
      <h3>🔍 LOGIN PAGE DEBUG</h3>
      Session started: " . session_id() . "<br>
      Current session data: <pre>";
print_r($_SESSION);
echo "</pre></div>";

$success=0;
$user=0;

if($_SERVER['REQUEST_METHOD']=='POST'){
    include 'connect.php';
    $username=$_POST['username'];
    $password=$_POST['password'];
    
    // ✅ ADD DEBUG
    echo "<div style='background:#e3f2fd; padding:10px; margin:10px;'>
          Login attempt: $username / $password
          </div>";

    $sql="Select * from `registration` where username='$username' and password='$password'";
    
    // ✅ ADD DEBUG
    echo "<div style='background:#fff3cd; padding:10px; margin:10px;'>
          SQL: $sql
          </div>";

    $result=mysqli_query($con,$sql);
    if($result){
        $num=mysqli_num_rows($result);
        
        // ✅ ADD DEBUG
        echo "<div style='background:#d4edda; padding:10px; margin:10px;'>
              Rows found: $num
              </div>";
              
        if($num>0){
            $row = mysqli_fetch_assoc($result); // ✅ Get the row
            
            // ✅ ADD DEBUG
            echo "<div style='background:#c8e6c9; padding:10px; margin:10px;'>
                  User found in database:<br>
                  ID: {$row['id']}<br>
                  Username: {$row['username']}
                  </div>";
            
            $user=1;
            
            // ✅ Store in session
            $_SESSION['username']=$username;
            $_SESSION['user_id'] = $row['id']; // ✅ Get ID from database
            
            // ✅ ADD DEBUG BEFORE REDIRECT
            echo "<div style='background:#d1ecf1; padding:15px; margin:10px;'>
                  <h4>✅ LOGIN SUCCESSFUL!</h4>
                  Session will store:<br>
                  - username: {$username}<br>
                  - user_id: {$row['id']}<br>
                  Redirecting to home.php...
                  </div>";
            
            // ✅ ADD exit() after header redirect
            header('location:home.php');
            exit(); // ⭐⭐⭐ THIS IS WHAT'S MISSING! ⭐⭐⭐
            
        }else{
            $user=0;
            echo "<div style='background:#f8d7da; padding:10px; margin:10px;'>
                  ❌ No user found with those credentials
                  </div>";
        }
    } else {
        echo "<div style='background:#f8d7da; padding:10px; margin:10px;'>
              ❌ SQL Error: " . mysqli_error($con) . "
              </div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .debug-info {
            background: #f8f9fa;
            border-left: 4px solid #007bff;
            padding: 15px;
            margin: 20px 0;
            font-family: monospace;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="debug-info">
            <h5>⚠️ Debug Mode Active</h5>
            <p>This page shows debug information. Remove the debug code when working.</p>
        </div>
        
        <?php
        if($user == 0 && $_SERVER['REQUEST_METHOD'] == 'POST'){
            echo '<div class="alert alert-danger" role="alert">
                  ❌ Wrong Username or Password!
                  </div>';
        }
        ?>

        <div class="card shadow" style="max-width: 500px; margin: 0 auto;">
            <div class="card-header bg-primary text-white">
                <h1 class="text-center mb-0">Log In</h1>
            </div>
            <div class="card-body">
                <form method="post">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Username</label>
                        <input type="text" class="form-control" name="username" required 
                               placeholder="Enter your username">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Password</label>
                        <input type="password" class="form-control" name="password" required 
                               placeholder="Enter your password">
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg w-100">
                        🔑 Login
                    </button>
                    <p class="text-center mt-3">
                        Don't have an account? <a href="signup.php">Sign up here</a>
                    </p>
                </form>
            </div>
        </div>
        
        <div class="mt-4">
            <h5>Test Credentials (if any):</h5>
            <?php
            include 'connect.php';
            $test_users = mysqli_query($con, "SELECT username FROM registration LIMIT 3");
            echo "<ul>";
            while ($test = mysqli_fetch_assoc($test_users)) {
                echo "<li>Username: " . $test['username'] . "</li>";
            }
            echo "</ul>";
            ?>
        </div>
    </div>
</body>
</html>