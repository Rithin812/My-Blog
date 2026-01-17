<?php require_once('db.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Blog</title>
    <!-- Google Fonts: Inter & Fira Code -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@700&family=Inter:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/my_blog/assets/style.css">
</head>
<body>
    <header>
        <div class="container">
            <div class="logo">
                <a href="/my_blog/index.php"><h1>My Blog</h1></a>
            </div>
            <nav>
                <ul>
                    <li><a href="/my_blog/index.php">Home</a></li>
                    <?php if (isLoggedIn()): ?>
                        <li><a href="/my_blog/admin/index.php">Admin Dashboard</a></li>
                        <li><a href="/my_blog/logout.php">Logout</a></li>
                    <?php else: ?>
                        <li><a href="/my_blog/login.php">Login</a></li>
                        <li><a href="/my_blog/register.php">Register</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
            <div class="search-bar">
                <form action="/my_blog/search.php" method="GET">
                    <input type="text" name="query" placeholder="Search posts..." required>
                    <button type="submit">Search</button>
                </form>
            </div>
        </div>
    </header>
    <main>
        <div class="container">