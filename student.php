<?php
session_start();
require_once("config/connect.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lost and Found Signin</title>
    <link rel="stylesheet" href="CSS/student.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    
</head>
<body>
   <div class="login-container">
        <h1>Log in using your AMS credentials</h1>
        <form id="loginForm" >
            <div id="errorMessage" class="error" style="display: none;"></div>
            
            <div class="form-group">
                <label for="username">Strathmore Email*</label>
                <input type="text" id="username" name="username" required placeholder="user@strathmore.edu">
            </div>
            
            <div class="form-group">
                <label for="password">Password*</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <div class="remember-me">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember">Remember me</label>
            </div>
            
            <button type="submit">login</button>
            
            <div class="register-link">
                Don't have an account? <a href="studentregister.php">Register here</a>
        </form>
    </div>
    

    <script>
        document.getElementById('loginForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;
            const errorElement = document.getElementById('errorMessage');
            
            // Clear previous errors
            errorElement.style.display = 'none';
            
            // Validate Strathmore email format
            if (!username.endsWith('@strathmore.edu')) {
                errorElement.textContent = 'Please use your Strathmore University email address (@strathmore.edu)';
                errorElement.style.display = 'block';
                return;
            }
            // Validate password length
            if (password.length < 8) {
                errorElement.textContent = 'Password must be at least 8 characters long';
                errorElement.style.display = 'block';
                return;
            }
            // Simulate a login request
            try {
    const response = await fetch('/api/studentlogin.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            strathmoreEmail: username,
            password: password
        })

    });
    
    const data = await response.json();
    
    if (response.ok) {
        // Successful login
        localStorage.setItem('authToken', data.token);
        console.log('Login successful, redirecting...');
        window.location.href = 'dashboard.html'; // Try full path if needed
    } else {
        // Show error message
        errorElement.textContent = data.message || 'Login failed';
        errorElement.style.display = 'block';
    }
} catch (error) {
    errorElement.textContent = 'Network error. Please try again.';
    errorElement.style.display = 'block';
    console.error('Login error:', error);
}

            
            // Simulate a successful login
            // In a real application, you would send the credentials to the server here
            console.log('Login successful for:', username);
            
            // Redirect to the dashboard or another page
            window.location.href = 'dashboard.html'; // Change to your actual dashboard URL
        });
    </script>
</body>
</html>