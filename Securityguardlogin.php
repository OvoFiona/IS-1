<?php
session_start();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lost and Found Login</title>
    <link rel="stylesheet" href="CSS/Securityguardlogin.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    
</head>
<body>
   <div class="login-container">
        <h1>Log in using your AMS credentials</h1>
        <form id="loginForm">
            <div id="errorMessage" class="error" style="display: none;"></div>
            
            <div class="form-group">
                <label for="username">Email*</label>
                <input type="email" id="email" name="email" required placeholder="user@strathmore.edu">
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
            
            
        </form>
    </div>
    

    <script>
        document.getElementById('loginForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value;
    const errorElement = document.getElementById('errorMessage');

    errorElement.style.display = 'none';

    if (!email.endsWith('@strathmore.edu')) {
        errorElement.textContent = 'Please use your Strathmore University email address.';
        errorElement.style.display = 'block';
        return;
    }

    if (password.length < 8) {
        errorElement.textContent = 'Password must be at least 8 characters long.';
        errorElement.style.display = 'block';
        return;
    }

    try {
        const response = await fetch(window.location.href, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ email, password })
        });

        const result = await response.json();

        if (result.success) {
            window.location.href = 'sgdashboard.php';
        } else {
            errorElement.textContent = result.message;
            errorElement.style.display = 'block';
        }
    } catch (error) {
        errorElement.textContent = 'Network error. Please try again.';
        errorElement.style.display = 'block';
        console.error(error);
    }
});

    </script>
</body>
</html>