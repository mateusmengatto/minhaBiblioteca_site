<?php
include 'functions.php';

// Connect to the database
$conn = bdconnect();

// Check if email exists
if(isset($_GET['email'])){
    $email = mysqli_real_escape_string($conn, $_GET['email']);
    $response = isEmailExists($conn, 'Usuario ', $email) ? 'exists' : 'notexists';
    echo $response;
}

// Close database connection
$conn->close();
?>
