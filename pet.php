<?php
session_start();
$success=0;
$showmessage=0;

if(!isset($_SESSION['user_id'])){
    header('location:signin.php');
    exit();
}
if($_SERVER['REQUEST_METHOD']=='POST'){
    include 'connect.php';

    //get form data inserted
    $pet_name=$_POST['pet_name'];
    $pet_age=$_POST['pet_age'];
    $pet_type=$_POST['pet_type'];
    $user_id=$_SESSION['user_id'];

    $sql="INSERT INTO `pets` (pet_name,pet_age,pet_type,user_id) VALUES ('$pet_name',$pet_age,'$pet_type',$user_id)";
    $result=mysqli_query($con,$sql);
    if($result){
        $success=1;
        $showmessage=1;

    }else{
         $success=0;
        $showmessage=1;
        die(mysqli_error($con));
    }
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
    <?php
    if($success&&$showmessage){
        echo "<div class=\"alert alert-success\" role=\"alert\">
          Pet added successfully!
        </div>";
    }else if(!$success&&$showmessage){
        echo "<div class=\"alert alert-danger\" role=\"alert\">
          Error adding pet!
        </div>";
    }
    ?>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Welcome, Add Your Pet</h1>
        
        <form method="post" class="border p-4 rounded shadow" style="max-width: 500px; margin: 0 auto;">
            <div class="mb-3">
                <label class="form-label fw-bold">Pet Name</label>
                <input type="text" class="form-control" name="pet_name" required 
                       placeholder="Enter pet name">
            </div>
            
            <div class="mb-3">
                <label class="form-label fw-bold">Pet Type</label>
                <input type="text" class="form-control" name="pet_type" required 
                       placeholder="e.g., Dog, Cat, Bird, Rabbit">
                <small class="text-muted">Enter the species/type of your pet</small>
            </div>
            
            <div class="mb-3">
                <label class="form-label fw-bold">Pet Age (years)</label>
                <input type="number" class="form-control" name="pet_age" 
                       min="0" max="50" required placeholder="Enter age">
            </div>
            
            <button type="submit" class="btn btn-primary btn-lg w-100">
                🐾 Add Pet
            </button>
            
            <a href="home.php" class="btn btn-outline-secondary w-100 mt-2">
                ← Back to Home
            </a>
        </form>
    </div>
</body>
</html>