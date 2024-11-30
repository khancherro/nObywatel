<?php
session_start();

$users = array(
    "admin" => "OJBASB91GAJ",


); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (array_key_exists($username, $users) && $users[$username] === $password) {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        
        header("Location: dashboard.php");
        exit;    } else {
        echo "Invalid auth key.";
    }
} else {
    header("Location: index.php");
    exit; 
}
?>


