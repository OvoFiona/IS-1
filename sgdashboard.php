<?php
session_start();
if (!isset($_SESSION['security_guard_email'])) {
    header("Location: Securityguardlogin.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lost & Found Dashboard</title>
    <link rel="stylesheet" href="CSS/sgdashboard.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    
</head>
<body>
    <div class="dashboard">
        <header>
            <div class="logo">Lost & Found System</div>
            <div class="user-info">
                <span>Welcome, Security Guard</span>
                <button class="logout-btn" id="logoutBtn">Logout</button>
            </div>
        </header>
        
        <div class="main-content">
            <div class="welcome-message">
                <h1>Welcome to Your Dashboard</h1>
                <p>What would you like to do today?</p>
            </div>

             <!--button-->
    <div class="button">
        <a href="upload.php" class="action-btn"> Upload </a>
        <a href="record.php" class="action-btn"> Record </a>
        <a href="verify.php" class="action-btn"> verify </a>
        
    </div>
    
    <br><br>
                    
        <footer>
            <p>&copy; 2025 Lost & Found System. All rights reserved.</p>
        </footer>
    </div>
    <script>
        document.getElementById('logoutBtn').addEventListener('click', function() {
            // Simulate logout action
            alert('You have been logged out.');
            window.location.href = 'index.php'; // Redirect to login page
        });
    </script>
</div>
</body>
</html>