<?php
require_once('../includes/header.php');
if (!isLoggedIn()) {
    redirect('../login.php');
}

if (!isset($_GET['id'])) {
    redirect('index.php');
}

$post_id = intval($_GET['id']);
$user_id = $_SESSION['user_id'];

// Fetch the post to ensure the logged-in user owns it
$sql = "SELECT * FROM posts WHERE id = $post_id AND user_id = $user_id";
$result = mysqli_query($conn, $sql);
$post = mysqli_fetch_assoc($result);

if (!$post) {
    redirect('index.php'); // Or show an error
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $category_id = intval($_POST['category_id']);

    $update_sql = "UPDATE posts SET title = '$title', content = '$content', category_id = $category_id WHERE id = $post_id";
    
    if (mysqli_query($conn, $update_sql)) {
        redirect('index.php');
    } else {
        $error = "Error updating record: " . mysqli_error($conn);
    }
}
?>
<h1>Edit Post</h1>
<?php if (isset($error)) { echo "<p style='color:red;'>$error</p>"; } ?>
<form action="edit_post.php?id=<?php echo $post_id; ?>" method="POST">
    <div class="form-group">
        <label for="title">Title</label>
        <input type="text" name="title" id="title" value="<?php echo htmlspecialchars($post['title']); ?>" required>
    </div>
    <div class="form-group">
        <label for="content">Content</label>
        <textarea name="content" id="content" rows="10" required><?php echo htmlspecialchars($post['content']); ?></textarea>
    </div>
    <div class="form-group">
        <label for="category_id">Category</label>
        <select name="category_id" id="category_id" required>
            <?php
            $cat_sql = "SELECT * FROM categories ORDER BY name ASC";
            $cat_result = mysqli_query($conn, $cat_sql);
            while ($category = mysqli_fetch_assoc($cat_result)) {
                $selected = ($category['id'] == $post['category_id']) ? 'selected' : '';
                echo '<option value="' . $category['id'] . '" ' . $selected . '>' . htmlspecialchars($category['name']) . '</option>';
            }
            ?>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Update Post</button>
</form>

<?php require_once('../includes/footer.php'); ?>