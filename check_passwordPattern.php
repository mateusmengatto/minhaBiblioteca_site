<?php
include 'functions.php';

if (isset($_GET['senha'])) {
    $password = $_GET['senha'];
    
    $response = isPasswordPattern($password) ? 'Checked' : 'Fail';
    echo $response;
}
?>
