<?php
session_start();
include 'connect.php';
if (!isset($_SESSION['user_id'])) {
    header('location: signin.php');
    exit();
}

// Get pet_id from URL when page first loads
$pet_id = $_GET['update_id'] ?? '';

// Load pet info
$sql = "SELECT * FROM `pets` WHERE pet_id='$pet_id' AND user_id='{$_SESSION['user_id']}'";
$result = mysqli_query($con, $sql);
    
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $pet_name = $row['pet_name'];
    $pet_age = $row['pet_age'];
    $pet_type = $row['pet_type'];
} else {
    die("Pet not found or no permission!");
}

// Handle form submission
if(isset($_POST['submit'])){
    $pet_id = $_POST['pet_id']; // Get from hidden field
    $pet_name = $_POST['pet_name'];
    $pet_age = $_POST['pet_age'];
    $pet_type = $_POST['pet_type'];
    $user_id = $_SESSION['user_id'];

    $sql = "UPDATE `pets` SET pet_name='$pet_name', pet_age='$pet_age', pet_type='$pet_type' WHERE pet_id='$pet_id' AND user_id='$user_id'";
    
    $result = mysqli_query($con, $sql);
    
    if($result){
        header('location: home.php');
        exit();
    } else {
        die("Update error: " . mysqli_error($con));
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Your Pet</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Edit Your Pet</h1>
        
        <form method="post" class="border p-4 rounded shadow" style="max-width: 500px; margin: 0 auto;">
            <!-- HIDDEN FIELD TO PASS PET ID ON FORM SUBMIT -->
            <input type="hidden" name="pet_id" value="<?php echo $pet_id; ?>">
            
            <div class="mb-3">
                <label class="form-label fw-bold">Pet Name</label>
                <input type="text" class="form-control" name="pet_name" required 
                       placeholder="Enter pet name" value="<?php echo $pet_name; ?>">
            </div>
            
            <div class="mb-3">
                <label class="form-label fw-bold">Pet Type</label>
                <input type="text" class="form-control" name="pet_type" required 
                       placeholder="e.g., Dog, Cat, Bird, Rabbit" value="<?php echo $pet_type; ?>">
                <small class="text-muted">Enter the species/type of your pet</small>
            </div>
            
            <div class="mb-3">
                <label class="form-label fw-bold">Pet Age (years)</label>
                <input type="number" class="form-control" name="pet_age" 
                       min="0" max="50" required placeholder="Enter age" value="<?php echo $pet_age; ?>">
            </div>
            
            <!-- ADDED name="submit" TO BUTTON -->
            <button type="submit" name="submit" class="btn btn-primary btn-lg w-100">
                🐾 Update Pet
            </button>
            
            <a href="home.php" class="btn btn-outline-secondary w-100 mt-2">
                ← Back to Home
            </a>
        </form>
    </div>
</body>
</html>