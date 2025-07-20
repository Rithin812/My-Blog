<?php
require_once('includes/header.php');

if (!isset($_GET['id'])) {
    redirect('index.php');
}

$post_id = intval($_GET['id']);

// Handle comment submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $body = mysqli_real_escape_string($conn, $_POST['body']);
    
    $sql = "INSERT INTO comments (post_id, name, email, body) VALUES ($post_id, '$name', '$email', '$body')";
    mysqli_query($conn, $sql);
}


// Fetch the post
$sql = "SELECT posts.*, categories.name AS category_name, users.username 
        FROM posts 
        JOIN categories ON posts.category_id = categories.id 
        JOIN users ON posts.user_id = users.id
        WHERE posts.id = $post_id";
$result = mysqli_query($conn, $sql);
$post = mysqli_fetch_assoc($result);

if (!$post) {
    echo "<h1>Post not found</h1>";
    require_once('includes/footer.php');
    exit();
}
?>

<article class="post">
    <h1><?php echo htmlspecialchars($post['title']); ?></h1>
    <div class="post-meta">
        <span>Posted by <?php echo htmlspecialchars($post['username']); ?> on <?php echo date('F j, Y', strtotime($post['created_at'])); ?></span>
        | <span>Category: <a href="category.php?id=<?php echo $post['category_id']; ?>"><?php echo htmlspecialchars($post['category_name']); ?></a></span>
    </div>
    <div class="post-content">
        <?php echo nl2br($post['content']); ?>
    </div>
</article>

<div class="comments-section">
    <h3>Comments</h3>
    <?php
    // Fetch comments
    $sql_comments = "SELECT * FROM comments WHERE post_id = $post_id ORDER BY created_at DESC";
    $comments_result = mysqli_query($conn, $sql_comments);
    
    if (mysqli_num_rows($comments_result) > 0) {
        while ($comment = mysqli_fetch_assoc($comments_result)) {
            echo '<div class="comment">';
            echo '<p><strong>' . htmlspecialchars($comment['name']) . '</strong> on ' . date('F j, Y', strtotime($comment['created_at'])) . '</p>';
            echo '<p>' . htmlspecialchars($comment['body']) . '</p>';
            echo '</div>';
        }
    } else {
        echo '<p>No comments yet. Be the first to comment!</p>';
    }
    ?>

    <hr>
    <h3>Leave a Comment</h3>
    <form action="post.php?id=<?php echo $post_id; ?>" method="POST">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" required>
        </div>
        <div class="form-group">
            <label for="body">Comment</label>
            <textarea name="body" id="body" rows="5" required></textarea>
        </div>
        <button type="submit" class="btn">Submit Comment</button>
    </form>
</div>

<?php require_once('includes/footer.php'); ?>