<?php
include('includes/db.php');

if (isset($_GET['delete_id'])) {
    $deleteId = intval($_GET['delete_id']);
    $deleteQuery = "DELETE FROM donations WHERE id = $deleteId";
    if ($conn->query($deleteQuery)) {
        echo "<script>alert('Transaction deleted successfully!'); window.location.href='admin_transactions.php';</script>";
    } else {
        echo "<script>alert('Failed to delete transaction!');</script>";
    }
}

$query = "SELECT donations.id, donations.donor_name, donations.donor_email, products.name AS product_name, donations.amount, donations.donation_date 
          FROM donations 
          JOIN products ON donations.product_id = products.id";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Transactions</title>
    <link rel="stylesheet" href="css/style_admin.css">
    <style>
        .delete-btn {
            color: #fff;
            background-color: #e74c3c;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }
        .delete-btn:hover {
            background-color: #c0392b;
        }
    </style>
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
        <h1>Transactions</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Product</th>
                    <th>Amount</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo htmlspecialchars($row['donor_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['donor_email']); ?></td>
                        <td><?php echo htmlspecialchars($row['product_name']); ?></td>
                        <td>Rp. <?php echo number_format($row['amount'], 0, ',', '.'); ?></td>
                        <td><?php echo htmlspecialchars(date('d M Y, H:i', strtotime($row['donation_date']))); ?></td>
                        <td>
                            <a class="delete-btn" href="admin_transactions.php?delete_id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this transaction?');">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
