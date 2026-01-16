<?php require_once('includes/header.php'); ?>

<h1>All Blog Posts</h1>

<?php
$sql = "SELECT posts.*, categories.name AS category_name, users.username 
        FROM posts 
        JOIN categories ON posts.category_id = categories.id 
        JOIN users ON posts.user_id = users.id
        ORDER BY posts.created_at DESC";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($post = mysqli_fetch_assoc($result)) {
        echo '<article class="post">';
        echo '<h2><a href="post.php?id=' . $post['id'] . '">' . htmlspecialchars($post['title']) . '</a></h2>';
        echo '<div class="post-meta">';
        echo '<span>Posted by ' . htmlspecialchars($post['username']) . ' on ' . date('F j, Y', strtotime($post['created_at'])) . '</span>';
        echo ' | <span>Category: <a href="category.php?id=' . $post['category_id'] . '">' . htmlspecialchars($post['category_name']) . '</a></span>';
        echo '</div>';
        echo '<p>' . substr(strip_tags($post['content']), 0, 200) . '...</p>';
        echo '<a href="post.php?id=' . $post['id'] . '" class="read-more">Read More</a>';
        echo '</article>';
    }
} else {
    echo '<p>No posts found.</p>';
}
?>

<?php require_once('includes/footer.php'); ?>