<?php
session_start(); // This MUST be the first line

// Database connection credentials
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'blog_db');
// Create connection
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// A simple function to redirect
function redirect($url) {
    header("Location: " . $url);
    exit();
}

// A function to check if the user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}
?>