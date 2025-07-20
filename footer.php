</div>
    </main>
    <footer>
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> My Blog. All rights reserved.</p>
        </div>
    </footer>
    <script src="/my_blog/assets/script.js"></script>
</body>
</html>
<?php
// Close the database connection
if (isset($conn)) {
    mysqli_close($conn);
}
?>