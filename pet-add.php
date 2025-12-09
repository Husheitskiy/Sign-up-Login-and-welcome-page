<?php
session_start();
echo "<div style='background:#ffeb3b; padding:15px; margin:10px; border:2px solid orange;'>
      <h3>🔍 SESSION DEBUG</h3>
      User ID in session: " . ($_SESSION['user_id'] ?? 'NOT SET') . "<br>
      Username in session: " . ($_SESSION['username'] ?? 'NOT SET') . "<br>
      Full session: <pre>";
print_r($_SESSION);
echo "</pre></div>";
if(!isset($_SESSION['user_id'])){
    header('location:login.php');
    exit();
}

if($_SERVER['REQUEST_METHOD']=='POST'){
    include 'connect.php';
    
    // Get form data - CORRECTED: using 'p-type' not 'p-species'
    $pname = $_POST['p-name'];
    $page = $_POST['p-age'];
    $ptype = $_POST['p-type']; // ✅ CHANGED from p-species to p-type
    $user_id = $_SESSION['user_id'];

    // Debug: Show what we're inserting
    echo "<div style='background:#f0f0f0; padding:10px; margin:10px;'>
          <strong>Debug - Form Data Received:</strong><br>
          Pet Name: $pname<br>
          Pet Type: $ptype<br>
          Pet Age: $page<br>
          User ID: $user_id
          </div>";
    
    // SQL query - NOW CORRECT!
    $sql = "INSERT INTO `pets` (pet_name, pet_type, pet_age, user_id) 
            VALUES ('$pname', '$ptype', $page, $user_id)";
    
    echo "<div style='background:#e0e0ff; padding:10px; margin:10px;'>
          <strong>SQL Query:</strong><br>
          <code>$sql</code>
          </div>";
    
    $result = mysqli_query($con, $sql);
    
    if($result){
        echo "<div style='background:#90ee90; padding:20px; margin:10px; text-align:center;'>
              <h3>✅ SUCCESS!</h3>
              Pet '$pname' added successfully!<br>
              Redirecting to home page...
              </div>";
        
        $pet_id = mysqli_insert_id($con);
        $_SESSION['pet_name'] = $pname;
        $_SESSION['pet_id'] = $pet_id;
        
        // Redirect after 3 seconds
        echo "<script>
              setTimeout(function() {
                  window.location.href = 'home.php';
              }, 3000);
              </script>";
    } else {
        echo "<div style='background:#ffcccc; padding:20px; margin:10px;'>
              <h3>❌ ERROR!</h3>
              " . mysqli_error($con) . "
              </div>";
    }
    exit(); // Stop to see debug info
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Your Pet</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Add Your Pet</h1>
        
        <form method="post" class="border p-4 rounded shadow" style="max-width: 500px; margin: 0 auto;">
            <div class="mb-3">
                <label class="form-label fw-bold">Pet Name</label>
                <input type="text" class="form-control" name="p-name" required 
                       placeholder="Enter pet name">
            </div>
            
            <div class="mb-3">
                <label class="form-label fw-bold">Pet Type</label>
                <input type="text" class="form-control" name="p-type" required 
                       placeholder="e.g., Dog, Cat, Bird, Rabbit">
                <small class="text-muted">Enter the species/type of your pet</small>
            </div>
            
            <div class="mb-3">
                <label class="form-label fw-bold">Pet Age (years)</label>
                <input type="number" class="form-control" name="p-age" 
                       min="0" max="50" required placeholder="Enter age">
            </div>
            
            <button type="submit" class="btn btn-primary btn-lg w-100">
                🐾 Add Pet
            </button>
            
            <a href="home.php" class="btn btn-outline-secondary w-100 mt-2">
                ← Back to Home
            </a>
        </form>
        
        <div class="mt-4 alert alert-success">
            <h5>✅ Your Table is Ready!</h5>
            <p>Your pets table has all the correct columns:</p>
            <ul>
                <li>pet_id (auto-increment)</li>
                <li>pet_name (varchar)</li>
                <li>pet_type (varchar) ← This was added!</li>
                <li>user_id (int)</li>
                <li>pet_age (int)</li>
            </ul>
        </div>
    </div>
</body>
</html>