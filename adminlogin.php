<?php
session_start();
require_once("config/connect.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');

    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!preg_match('/^[a-z]+\.admin@strathmore\.edu$/', strtolower($email))) {
        echo json_encode(['success' => false, 'message' => 'invalid email format.']);
        exit;
    }

    $stmt = $conn->prepare("SELECT id, password FROM adminlogin WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($id, $hashedPassword);
        $stmt->fetch();

        if (password_verify($password, $hashedPassword)) {
            $_SESSION['admin_id'] = $id;
            $_SESSION['admin_email'] = $email;
            echo json_encode(['success' => true, 'message' => 'Login successful. Redirecting...']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Incorrect password.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Admin account not found.']);
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
  <title>Admin Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #2c3e50, #3498db);
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .card {
      padding: 30px;
      border-radius: 10px;
      background: white;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 400px;
    }
  </style>
</head>
<body>
<div class="card">
  <h4 class="text-center mb-4">Admin Login</h4>
  <div id="responseMessage" class="alert d-none"></div>
  <form id="loginForm">
    <div class="mb-3">
      <label for="email" class="form-label">Strathmore Admin Email</label>
      <input type="email" id="email" name="email" class="form-control" required placeholder="admin email">
    </div>
    <div class="mb-3">
      <label for="password" class="form-label">Password</label>
      <input type="password" id="password" name="password" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary w-100">Login</button>
  </form>
</div>

<script>
  const form = document.getElementById('loginForm');
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
        window.location.href = 'admin.php';
      }, 2000);
    }
  });
</script>
</body>
</html>
