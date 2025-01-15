<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login_admin.php');
    exit;
}
require_once 'includes/db.php';

$categories = $conn->query("SELECT * FROM categories");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_product'])) {
    $name = $_POST['name'];
    $category_id = $_POST['category_id'];
    $description = $_POST['description'];
    $goal_price = $_POST['goal_price'];

    if (isset($_FILES['thumbnail'])) {
        $thumbnail = $_FILES['thumbnail']['name'];
        $target_dir = "uploads/";  
        $target_file = $target_dir . basename($thumbnail);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($imageFileType, $allowed_types)) {
            $message = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $message_class = "error";
        } else {
            if (move_uploaded_file($_FILES['thumbnail']['tmp_name'], $target_file)) {
                $sql = "INSERT INTO products (name, category_id, description, goal_price, thumbnail) 
                        VALUES ('$name', '$category_id', '$description', '$goal_price', '$thumbnail')";
                $conn->query($sql);
                $message = "The file " . htmlspecialchars($thumbnail) . " has been uploaded.";
                $message_class = "success";
            } else {
                $message = "Sorry, there was an error uploading your file.";
                $message_class = "error";
            }
        }
    }
}


if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $sql = "DELETE FROM products WHERE id=$id";
    $conn->query($sql);
}

$products = $conn->query("SELECT products.*, categories.name AS category_name 
                          FROM products JOIN categories ON products.category_id = categories.id");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Products</title>
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
    <h1>Products</h1>

    <?php if (isset($message)): ?>
    <div class="message <?= $message_class; ?>">
        <?= $message; ?>
    </div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data" class="form-control">
        <input type="text" name="name" placeholder="Product Name" required>
        <select name="category_id" required>
            <?php while ($row = $categories->fetch_assoc()): ?>
            <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
            <?php endwhile; ?>
        </select>
        <textarea name="description" placeholder="Description" required></textarea>
        <input type="number" name="goal_price" placeholder="Goal Price (IDR)" required>
        <input type="file" name="thumbnail" required>
        <button type="submit" name="add_product" class="btn">Add Product</button>
    </form>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Category</th>
                <th>Description</th>
                <th>Goal Price</th>
                <th>Thumbnail</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $products->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['name'] ?></td>
                <td><?= $row['category_name'] ?></td>
                <td><?= $row['description'] ?></td>
                <td><?= number_format($row['goal_price'], 2) ?></td>
                <td><img src="uploads/<?= $row['thumbnail'] ?>" width="50" alt="Thumbnail"></td>
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
