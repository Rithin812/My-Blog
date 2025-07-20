<?php
require_once('includes/db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    // Basic validation
    if (empty($username) || empty($email) || empty($password)) {
        $error = "All fields are required.";
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashed_password')";
        
        if (mysqli_query($conn, $sql)) {
            redirect('login.php');
        } else {
            $error = "Error: " . mysqli_error($conn);
        }
    }
}
?>

<?php require_once('includes/header.php'); ?>

<h1>Register</h1>
<?php if (isset($error)) { echo "<p style='color:red;'>$error</p>"; } ?>
<form action="register.php" method="POST">
    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" required>
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" required>
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" required>
    </div>
    <button type="submit" class="btn">Register</button>
</form>

<?php require_once('includes/footer.php'); ?>