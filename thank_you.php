<?php
$name = isset($_GET['name']) ? urldecode($_GET['name']) : 'Donor';
$amount = isset($_GET['amount']) ? number_format(urldecode($_GET['amount']), 0, ',', '.') : '0';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You</title>
    <link rel="stylesheet" href="css/style_thank_you.css">
    <script>
        let countdown = 10;
        function startCountdown() {
            const timer = document.getElementById('timer');
            const interval = setInterval(() => {
                countdown--;
                timer.innerText = countdown;
                if (countdown <= 0) {
                    clearInterval(interval);
                    window.location.href = 'index.php';
                }
            }, 1000);
        }
        window.onload = startCountdown;
    </script>
</head>
<body>
    <div class="thank-you-message">
        <h2>Thank You, <?php echo htmlspecialchars($name); ?>!</h2>
        <p>You have donated <strong>Rp. <?php echo $amount; ?></strong>.</p>
        <p>Semoga rezeki Anda selalu dilimpahkan dan amal kebaikan ini menjadi berkah.</p>
        <p>Redirecting to the homepage in <span id="timer">10</span> seconds...</p>
    </div>
</body>
</html>
