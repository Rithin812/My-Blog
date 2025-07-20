<?php
require_once('../includes/db.php');
if (!isLoggedIn()) {
    redirect('../login.php');
}

if (!isset($_GET['id'])) {
    redirect('index.php');
}

$post_id = intval($_GET['id']);
$user_id = $_SESSION['user_id'];

// Delete post only if it belongs to the logged-in user
$sql = "DELETE FROM posts WHERE id = $post_id AND user_id = $user_id";

mysqli_query($conn, $sql);

redirect('index.php');
?>