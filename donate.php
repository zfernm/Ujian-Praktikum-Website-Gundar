<?php
include('includes/db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $campaign = $_POST['campaign'];
    
    $amount = $_POST['amount'] == 'custom' ? $_POST['custom_amount'] : $_POST['amount'];

    if ($_POST['amount'] == 'custom' && (empty($amount) || $amount <= 0)) {
        die("Please enter a valid custom amount.");
    }

    $query = "INSERT INTO donations (product_id, donor_name, donor_email, amount) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("issd", $campaign, $name, $email, $amount);
    $stmt->execute();

    $update_query = "UPDATE products SET current_price = current_price + ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("di", $amount, $campaign);
    $update_stmt->execute();

    header("Location: thank_you.php?name=" . urlencode($name) . "&amount=" . urlencode($amount));
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donate</title>
    <!-- <link rel="stylesheet" href="css/style_donate.css"> -->
     <link rel="stylesheet" href="css/style_donation.css">
</head>
<body>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="donate.php">Donate</a></li>
            <li><a href="campign_user.php">Campaigns</a></li>
            <li><a href="login_admin.php">Login Admin</a></li>
        </ul>
    </nav>
    <div class="donation-form">
        <h2>Donate Now</h2>
        <form action="" method="POST">
            <input type="text" name="name" placeholder="Your Full Name" required>
            <input type="email" name="email" placeholder="Your Email" required>
            <select name="campaign" required>
                <option value="" disabled selected>Select Campaign</option>
                <?php
                $result = $conn->query("SELECT id, name FROM products");
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='{$row['id']}'>{$row['name']}</option>";
                }
                ?>
            </select>
            <label>Amount:</label>
            <input type="radio" name="amount" value="10000" required> Rp. 10K
            <input type="radio" name="amount" value="20000"> Rp. 20K
            <input type="radio" name="amount" value="50000"> Rp. 50K
            <input type="radio" name="amount" value="100000"> Rp. 100K
            <input type="radio" name="amount" value="custom" id="custom-radio"> 
            <label for="custom-radio">Custom</label>
            <input type="number" name="custom_amount" id="custom-amount" placeholder="Custom Amount" disabled>
            <button type="submit">Donate Now</button>

            <script>
                const customRadio = document.getElementById('custom-radio');
                const customAmountInput = document.getElementById('custom-amount');

                customRadio.addEventListener('change', () => {
                    customAmountInput.disabled = !customRadio.checked;
                    if (!customRadio.checked) customAmountInput.value = ''; 
                });
            </script>
        </form>
    </div>
</body>
</html>
