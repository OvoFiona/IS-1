<?php
session_start();
require_once("config/connect.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');

    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Enforce format: firstname.admin@strathmore.edu
    if (!preg_match('/^[a-z]+\.admin@strathmore\.edu$/', strtolower($email))) {
        echo json_encode(['success' => false, 'message' => 'Email must follow format firstname.admin@strathmore.edu']);
        exit;
    }

    if (strlen($password) < 8) {
        echo json_encode(['success' => false, 'message' => 'Password must be at least 8 characters long.']);
        exit;
    }

    if ($password !== $confirm_password) {
        echo json_encode(['success' => false, 'message' => 'Passwords do not match.']);
        exit;
    }

    $stmt = $conn->prepare("SELECT id FROM adminlogin WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo json_encode(['success' => false, 'message' => 'Email already exists.']);
        exit;
    }
    $stmt->close();

    $hashed = password_hash($password, PASSWORD_BCRYPT);
    $stmt = $conn->prepare("INSERT INTO adminlogin (Email, password, created, updated) VALUES (?, ?, NOW(), NOW())");
    $stmt->bind_param("ss", $email, $hashed);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Admin registered successfully. Redirecting...']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Registration failed.']);
    }

    $stmt->close();
    $conn->close();
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Sign Up</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #2c3e50, #3498db);
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .card {
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
      max-width: 450px;
      width: 100%;
      background: #fff;
    }
  </style>
</head>
<body>
  <div class="card">
    <h4 class="text-center mb-3">Admin Sign Up</h4>
    <div id="responseMessage" class="alert d-none"></div>

    <form id="signupForm" method="POST">
      <div class="mb-3">
        <label for="email" class="form-label">Strathmore Admin Email</label>
        <input type="email" id="email" name="email" class="form-control" required placeholder="admin email">
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password (min 8 chars)</label>
        <input type="password" id="password" name="password" class="form-control" required minlength="8">
      </div>
      <div class="mb-3">
        <label for="confirm_password" class="form-label">Confirm Password</label>
        <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-primary w-100">Sign Up</button>
    </form>
  </div>

  <script>
    const form = document.getElementById('signupForm');
    const messageBox = document.getElementById('responseMessage');

    form.addEventListener('submit', async function (e) {
      e.preventDefault();
      const formData = new FormData(form);

      const response = await fetch('', {
        method: 'POST',
        body: new URLSearchParams(formData)
      });

      const result = await response.json();
      messageBox.classList.remove('d-none', 'alert-success', 'alert-danger');
      messageBox.classList.add(result.success ? 'alert-success' : 'alert-danger');
      messageBox.textContent = result.message;

      if (result.success) {
        setTimeout(() => {
          window.location.href = 'adminlogin.php';
        }, 2000);
      }
    });
  </script>
</body>
</html>
