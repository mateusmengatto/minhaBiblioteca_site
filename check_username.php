<?php
include 'functions.php';

// Connect to the database
$conn = bdconnect();

// Check if email exists
if(isset($_GET['username'])){
    $userName = mysqli_real_escape_string($conn, $_GET['username']);
    $response = isUserExists($conn, 'Usuario ', $userName) ? 'exists' : 'notexists';
    echo $response;
}

// Close database connection
$conn->close();
?>
