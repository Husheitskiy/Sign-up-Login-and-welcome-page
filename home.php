<?php
session_start();

// Check if logged in
if (!isset($_SESSION['user_id'])) {
    echo '<div class=\"alert alert-danger\" role=\"alert\">
         NOT LOGGED IN!
         </div>';
    header('refresh:3;url=signin.php');
    exit();
}

include 'connect.php';
$user_id=$_SESSION['user_id'];
$username=$_SESSION['username'];

$sql="SELECT * FROM `pets` WHERE user_id='$user_id' ORDER BY pet_id DESC";
$result=mysqli_query($con,$sql);
if(!$result){
    die(mysqli_error($con));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
 <button class="btn btn-primary"><a href="pet.php" class="text-light text-decoration-none">Add Pet</a></button>
    
<?php
echo "<header><h1>Welcome! $username</h1></header>";

// Check if there are any pets
if (mysqli_num_rows($result) > 0) {
    echo '
    <table class="table">
      <thead>
        <tr>
          <th scope="col">Pet ID</th>
          <th scope="col">Pet Name</th>
          <th scope="col">Pet Type</th>
          <th scope="col">Pet Age</th>
          <th scope="col">Operation</th>
        </tr>
      </thead>
      <tbody>';

    // Fetch and display all rows
    while ($row = mysqli_fetch_assoc($result)) {
        echo '
        <tr>
          <th scope="row">' . $row['pet_id'] . '</th>
          <td>' . $row['pet_name'] . '</td>
          <td>' . $row['pet_type'] . '</td>
          <td>' . $row['pet_age'] . '</td>
          <td>
            <a href="update.php?update_id=' . $row['pet_id'] . '" class="btn btn-primary btn-sm text-light">Update</a>
            <a onclick="return confirm(\'Delete?\')" href="delete.php?delete_id=' . $row['pet_id'] . '" class="btn btn-danger btn-sm text-light">Delete</a>
          </td>
        </tr>';
    }

    echo '
      </tbody>
    </table>';
} else {
    echo '<div class="alert alert-info mt-3">No pets found. Add your first pet!</div>';
}
?>
</body>

</html>