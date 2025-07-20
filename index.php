<?php
require_once('../includes/header.php');
if (!isLoggedIn()) {
    redirect('../login.php');
}
?>
<h1>Admin Dashboard</h1>
<p>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>

<nav class="admin-nav">
    <ul>
        <li><a href="add_post.php">Add New Post</a></li>
        <li><a href="categories.php">Manage Categories</a></li>
    </ul>
</nav>

<h3>Your Posts</h3>
<?php
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM posts WHERE user_id = $user_id ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    echo '<table>';
    echo '<tr><th>Title</th><th>Created At</th><th>Actions</th></tr>';
    while ($post = mysqli_fetch_assoc($result)) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($post['title']) . '</td>';
        echo '<td>' . date('F j, Y', strtotime($post['created_at'])) . '</td>';
        echo '<td>';
        echo '<a href="edit_post.php?id=' . $post['id'] . '">Edit</a> | ';
        echo '<a href="delete_post.php?id=' . $post['id'] . '" class="delete-link">Delete</a>';
        echo '</td>';
        echo '</tr>';
    }
    echo '</table>';
} else {
    echo '<p>You have not created any posts yet.</p>';
}
?>

<?php require_once('../includes/footer.php'); ?>