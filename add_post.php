<?php
require_once('../includes/header.php');
if (!isLoggedIn()) {
    redirect('../login.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $category_id = intval($_POST['category_id']);
    $user_id = $_SESSION['user_id'];

    $sql = "INSERT INTO posts (user_id, category_id, title, content) VALUES ($user_id, $category_id, '$title', '$content')";
    
    if (mysqli_query($conn, $sql)) {
        redirect('index.php');
    } else {
        $error = "Error: " . mysqli_error($conn);
    }
}
?>
<h1>Add New Post</h1>
<?php if (isset($error)) { echo "<p style='color:red;'>$error</p>"; } ?>
<form action="add_post.php" method="POST">
    <div class="form-group">
        <label for="title">Title</label>
        <input type="text" name="title" id="title" required>
    </div>
    <div class="form-group">
        <label for="content">Content</label>
        <textarea name="content" id="content" rows="10" required></textarea>
    </div>
    <div class="form-group">
        <label for="category_id">Category</label>
        <select name="category_id" id="category_id" required>
            <?php
            $cat_sql = "SELECT * FROM categories ORDER BY name ASC";
            $cat_result = mysqli_query($conn, $cat_sql);
            while ($category = mysqli_fetch_assoc($cat_result)) {
                echo '<option value="' . $category['id'] . '">' . htmlspecialchars($category['name']) . '</option>';
            }
            ?>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Publish Post</button>
</form>

<?php require_once('../includes/footer.php'); ?>