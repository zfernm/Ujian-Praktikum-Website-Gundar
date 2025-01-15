<?php
include('includes/db.php');

$query = "SELECT id, name, description, goal_price, current_price, thumbnail FROM products";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Campaigns</title>
    <link rel="stylesheet" href="css/style_campign_user.css">
    <style>
        .progress-container {
            width: 100%;
            background-color: #f3f3f3;
            border-radius: 20px;
            margin: 10px 0;
            overflow: hidden;
            height: 20px;
        }
        .progress-bar {
            height: 100%;
            width: 0;
            background-color: #4caf50;
            border-radius: 20px;
            animation: fillProgress 2s ease-out forwards;
        }
        @keyframes fillProgress {
            from {
                width: 0;
            }
            to {
                width: var(--progress-percent);
            }
        }
        .donor-list {
            margin-top: 10px;
            padding: 10px;
            background-color:rgb(49, 33, 121);
            border-radius: 10px;
            border: 1px solid #ddd;
        }
        .donor-list h4 {
            margin-bottom: 10px;
        }
        .donor-item {
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="donate.php">Donate</a></li>
            <li><a href="campign_user.php">Campaigns</a></li>
        </ul>
    </nav>

    <div class="campaigns">
        <h2>Campaigns</h2>
        <?php while ($row = $result->fetch_assoc()) : 
            $campaignId = $row['id'];
            $progress = $row['goal_price'] > 0 ? ($row['current_price'] / $row['goal_price']) * 100 : 0;
            $progress = $progress > 100 ? 100 : $progress;

            $donorQuery = "SELECT donor_name, amount AS donation_amount, donation_date 
               FROM donations 
               WHERE product_id = $campaignId 
               ORDER BY donation_date DESC";
            $donorResult = $conn->query($donorQuery);
            
            if (!$donorResult) {
                echo "<p>Error in donor query: " . $conn->error . "</p>";
            }
        ?>
            <div class="campaign">
                <h3><?= htmlspecialchars($row['name']) ?></h3>
                <p><?= htmlspecialchars($row['description']) ?></p>
                <p>Goal: Rp. <?= number_format($row['goal_price'], 0, ',', '.') ?></p>
                <p>Raised: Rp. <?= number_format($row['current_price'], 0, ',', '.') ?></p>
                <p>Progress: <?= number_format($progress, 2) ?>%</p>
                
                <?php if (!empty($row['thumbnail'])): ?>
                    <img src="uploads/<?= htmlspecialchars($row['thumbnail']) ?>" alt="Thumbnail" width="100">
                <?php endif; ?>

                <div class="progress-container">
                    <div class="progress-bar" style="--progress-percent: <?= $progress ?>%;"></div>
                </div>

                <div class="donor-list">
                    <h4>Donors:</h4>
                    <?php if ($donorResult && $donorResult->num_rows > 0): ?>
                        <?php while ($donor = $donorResult->fetch_assoc()): ?>
                            <div class="donor-item">
                                <p><strong><?= htmlspecialchars($donor['donor_name']) ?></strong></p>
                                <p>Donated: Rp. <?= number_format($donor['donation_amount'], 0, ',', '.') ?></p>
                                <p>Date: <?= htmlspecialchars(date('d M Y', strtotime($donor['donation_date']))) ?></p>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <p>No donors yet for this campaign.</p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</body>
</html>
