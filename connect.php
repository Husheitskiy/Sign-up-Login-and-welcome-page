<?php
$HOSTNAME = 'localhost';
$USERNAME = 'root';
$PASSWORD = '';
$DATABASE = 'signupforms';
$PORT     = 5200;

$con=mysqli_connect($HOSTNAME,$USERNAME,$PASSWORD,$DATABASE, $PORT);

if(!$con){
    die(mysqli_connect_error($con));
}

?>