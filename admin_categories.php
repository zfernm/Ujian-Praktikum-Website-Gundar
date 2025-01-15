<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login_admin.php');
    exit;
}
require_once 'includes/db.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_category'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $sql = "INSERT INTO categories (name, description) VALUES ('$name', '$description')";
    $conn->query($sql);
}

if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $sql = "DELETE FROM categories WHERE id=$id";
    $conn->query($sql);
}

$categories = $conn->query("SELECT * FROM categories");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Categories</title>
    <link rel="stylesheet" href="css/style_admin.css">
</head>
<body>
    <div class="sidebar">
        <h2>Admin Panel</h2>
        <ul>
            <li><a href="admin_dashboard.php">Dashboard</a></li>
            <li><a href="admin_categories.php">Categories</a></li>
            <li><a href="admin_products.php">Products</a></li>
            <li><a href="admin_transactions.php">Transactions</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>
    <div class="main-content">
        <h1>Categories</h1>
        <form method="POST" class="form-control">
            <input type="text" name="name" placeholder="Category Name" required>
            <textarea name="description" placeholder="Description" required></textarea>
            <button type="submit" name="add_category" class="btn">Add Category</button>
        </form>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $categories->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['name'] ?></td>
                    <td><?= $row['description'] ?></td>
                    <td>
                        <a href="?delete_id=<?= $row['id'] ?>" class="btn">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
