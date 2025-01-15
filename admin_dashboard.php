<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login_admin.php');
    exit;
}

include('includes/db.php');

$categoryQuery = "SELECT categories.name AS category_name, SUM(products.current_price) AS total_donations 
                  FROM products 
                  JOIN categories ON products.category_id = categories.id 
                  GROUP BY categories.name";
$categoryResult = $conn->query($categoryQuery);

$categories = [];
$categoryDonations = [];
while ($row = $categoryResult->fetch_assoc()) {
    $categories[] = $row['category_name'];
    $categoryDonations[] = $row['total_donations'];
}

$campaignQuery = "SELECT name AS campaign_name, current_price AS total_donated 
                  FROM products";
$campaignResult = $conn->query($campaignQuery);

$campaigns = [];
$campaignDonations = [];
while ($row = $campaignResult->fetch_assoc()) {
    $campaigns[] = $row['campaign_name'];
    $campaignDonations[] = $row['total_donated'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/style_admin.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .chart-container {
            width: 80%;
            margin: 20px auto;
        }
        canvas {
            display: block;
            margin: 0 auto;
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
        <div class="dashboard-welcome">
            <h1>Welcome, Admin</h1>
            <p>Manage your campaigns efficiently.</p>
        </div>

        <div class="chart-container">
            <h2>Donations by Category</h2>
            <canvas id="pieChart"></canvas>
        </div>
        <div class="chart-container">
            <h2>Campaign Performance</h2>
            <canvas id="barChart"></canvas>
        </div>
    </div>

    <script>
        const categories = <?= json_encode($categories) ?>;
        const categoryDonations = <?= json_encode($categoryDonations) ?>;

        const pieCtx = document.getElementById('pieChart').getContext('2d');
        new Chart(pieCtx, {
            type: 'pie',
            data: {
                labels: categories,
                datasets: [{
                    label: 'Total Donations',
                    data: categoryDonations,
                    backgroundColor: ['#ff6384', '#36a2eb', '#ffcd56', '#4caf50', '#ff9f40'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                }
            }
        });

        const campaigns = <?= json_encode($campaigns) ?>;
        const campaignDonations = <?= json_encode($campaignDonations) ?>;

        const barCtx = document.getElementById('barChart').getContext('2d');
        new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: campaigns,
                datasets: [{
                    label: 'Total Donations',
                    data: campaignDonations,
                    backgroundColor: '#36a2eb',
                    borderColor: '#36a2eb',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    </script>
</body>
</html>
