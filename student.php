<?php
session_start();
require_once("config/connect.php");

$errorMessage = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (!str_ends_with($email, '@strathmore.edu')) {
        $errorMessage = "Please use your Strathmore University email address.";
    } elseif (strlen($password) < 8) {
        $errorMessage = "Password must be at least 8 characters long.";
    } else {
        // ✅ CORRECTED: use $email (was mistakenly $Email)
        $stmt = $conn->prepare('SELECT Id, password FROM Studentlogin WHERE Email = ?');
        if (!$stmt) {
            $errorMessage = "Database error: " . $conn->error;
        } else {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 0) {
                $errorMessage = "Invalid credentials.";
            } else {
                $user = $result->fetch_assoc();
                if (password_verify($password, $user['password'])) {
                    $_SESSION['studentId'] = $user['Id'];
                    $_SESSION['email'] = $email;
                    header("Location: dashboard.html");
                    exit;
                } else {
                    $errorMessage = "Invalid credentials.";
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Lost and Found Signin</title>
  <link rel="stylesheet" href="CSS/student.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
  <div class="login-container">
    <h1>Log in using your AMS credentials</h1>

    <?php if (!empty($errorMessage)): ?>
      <div class="alert alert-danger mt-3"><?php echo htmlspecialchars($errorMessage); ?></div>
    <?php endif; ?>

    <form method="POST" class="mt-4">
      <div class="form-group">
        <label for="username">Strathmore Email*</label>
        <input type="text" id="username" name="username" class="form-control" required placeholder="user@strathmore.edu" />
      </div>

      <div class="form-group mt-3">
        <label for="password">Password*</label>
        <input type="password" id="password" name="password" class="form-control" required />
      </div>

      <div class="form-check my-3">
        <input type="checkbox" class="form-check-input" id="remember" name="remember" />
        <label for="remember" class="form-check-label">Remember me</label>
      </div>

      <button type="submit" class="btn btn-success w-100">Login</button>

      <div class="register-link mt-3">
        Don't have an account? <a href="studentregister.php">Register here</a>
      </div>
    </form>
  </div>
</body>
</html>
