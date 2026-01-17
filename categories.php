<?php
require_once('../includes/header.php');
if (!isLoggedIn()) {
    redirect('../login.php');
}

// Handle form submission for adding/editing a category
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    
    if (isset($_POST['id']) && !empty($_POST['id'])) { // Update
        $id = intval($_POST['id']);
        $sql = "UPDATE categories SET name='$name', description='$description' WHERE id=$id";
    } else { // Insert
        $sql = "INSERT INTO categories (name, description) VALUES ('$name', '$description')";
    }
    
    if (!mysqli_query($conn, $sql)) {
        $error = "Error: " . mysqli_error($conn);
    }
}

// Handle deletion
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $sql = "DELETE FROM categories WHERE id=$id";
    mysqli_query($conn, $sql);
    redirect('categories.php');
}

// Fetch category for editing if 'edit' is in URL
$edit_cat = null;
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $result = mysqli_query($conn, "SELECT * FROM categories WHERE id=$id");
    $edit_cat = mysqli_fetch_assoc($result);
}
?>

<h1>Manage Categories</h1>
<?php if (isset($error)) { echo "<p style='color:red;'>$error</p>"; } ?>

<form action="categories.php" method="POST">
    <input type="hidden" name="id" value="<?php echo $edit_cat ? $edit_cat['id'] : ''; ?>">
    <div class="form-group">
        <label for="name">Category Name</label>
        <input type="text" name="name" id="name" value="<?php echo $edit_cat ? htmlspecialchars($edit_cat['name']) : ''; ?>" required>
    </div>
    <div class="form-group">
        <label for="description">Description</label>
        <textarea name="description" id="description" rows="3"><?php echo $edit_cat ? htmlspecialchars($edit_cat['description']) : ''; ?></textarea>
    </div>
    <button type="submit" class="btn"><?php echo $edit_cat ? 'Update' : 'Add'; ?> Category</button>
</form>

<hr>

<h3>Existing Categories</h3>
<table>
    <tr><th>Name</th><th>Description</th><th>Actions</th></tr>
    <?php
    $result = mysqli_query($conn, "SELECT * FROM categories ORDER BY name ASC");
    while ($cat = mysqli_fetch_assoc($result)) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($cat['name']) . '</td>';
        echo '<td>' . htmlspecialchars($cat['description']) . '</td>';
        echo '<td>';
        echo '<a href="categories.php?edit=' . $cat['id'] . '">Edit</a> | ';
        echo '<a href="categories.php?delete=' . $cat['id'] . '" class="delete-link">Delete</a>';
        echo '</td>';
        echo '</tr>';
    }
    ?>
</table>

<?php require_once('../includes/footer.php'); ?>