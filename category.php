<?php
require_once('includes/header.php');

if (!isset($_GET['id'])) {
    redirect('index.php');
}
$cat_id = intval($_GET['id']);

// Fetch category name
$cat_sql = "SELECT name FROM categories WHERE id = $cat_id";
$cat_result = mysqli_query($conn, $cat_sql);
$category = mysqli_fetch_assoc($cat_result);

if (!$category) {
     echo '<h1>Category not found.</h1>';
} else {
    echo '<h1>Posts in Category: ' . htmlspecialchars($category['name']) . '</h1>';
    
    $sql = "SELECT posts.*, users.username FROM posts JOIN users ON posts.user_id = users.id WHERE posts.category_id = $cat_id ORDER BY posts.created_at DESC";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) > 0) {
        while ($post = mysqli_fetch_assoc($result)) {
            echo '<article class="post">';
            echo '<h2><a href="post.php?id=' . $post['id'] . '">' . htmlspecialchars($post['title']) . '</a></h2>';
            echo '<div class="post-meta">';
            echo '<span>Posted by ' . htmlspecialchars($post['username']) . ' on ' . date('F j, Y', strtotime($post['created_at'])) . '</span>';
            echo '</div>';
            echo '<p>' . substr(strip_tags($post['content']), 0, 200) . '...</p>';
            echo '<a href="post.php?id=' . $post['id'] . '" class="read-more">Read More</a>';
            echo '</article>';
        }
    } else {
        echo '<p>No posts found in this category.</p>';
    }
}
?>

<?php require_once('includes/footer.php'); ?>