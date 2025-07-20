<?php
require_once('includes/header.php');

if (!isset($_GET['query']) || empty($_GET['query'])) {
    echo '<h1>Please enter a search term.</h1>';
} else {
    $query = mysqli_real_escape_string($conn, $_GET['query']);
    echo '<h1>Search Results for: "' . htmlspecialchars($query) . '"</h1>';
    
    $sql = "SELECT posts.*, categories.name AS category_name, users.username 
            FROM posts 
            JOIN categories ON posts.category_id = categories.id 
            JOIN users ON posts.user_id = users.id
            WHERE posts.title LIKE '%$query%' OR posts.content LIKE '%$query%'
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
        echo '<p>No posts found matching your search term.</p>';
    }
}
?>

<?php require_once('includes/footer.php'); ?>