<?php
// Include the database connection
require_once("config/connect.php");

// Check if the request method is POST and content is JSON
if ($_SERVER['REQUEST_METHOD'] === 'POST' && strpos($_SERVER['CONTENT_TYPE'], 'application/json') !== false) {
    // Read and decode the JSON input
    $data = json_decode(file_get_contents('php://input'), true);

    $email = trim($data['email'] ?? '');
    $password = $data['password'] ?? '';
    $confirm_password = $data['confirm_password'] ?? '';

    header('Content-Type: application/json');

    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !str_ends_with($email, '@strathmore.edu')) {
        echo json_encode(['success' => false, 'message' => 'Invalid Strathmore email address.']);
        exit;
    }
    // Validate email format:
    if (!preg_match('/^[A-Z][a-z0-9]*@strathmore\.edu$/', $email)) {
    echo json_encode(['success' => false, 'message' => 'Email must start with a capital letter and end with @strathmore.edu ']);
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

    // Check if email already exists
    $stmt = $conn->prepare("SELECT id FROM securityguardlogin WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo json_encode(['success' => false, 'message' => 'An account with this email already exists.']);
        exit;
    }

    $stmt->close();

    // Insert new user
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO securityguardlogin (Email, password, created, updated) VALUES (?, ?, NOW(), NOW())");
    $stmt->bind_param("ss", $email, $hashed_password);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Registration successful. Redirecting...']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $stmt->error]);
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Security Guard Registration</title>
    <link rel="stylesheet" href="CSS/Security Guard.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
  body {
    background: linear-gradient(135deg, #2c3e50, #3498db);
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 30px;
  }

  .card {
    background: #fff;
    padding: 30px;
    border-radius: 1rem;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 480px;
  }

  .btn-primary {
    width: 100%;
    font-weight: 500;
  }

  .login-link {
    text-align: center;
    margin-top: 15px;
  }
</style>
</head>
<body>
    <div class="registration-container">
        <h2>Create Your Account</h2>
        <div id="responseMessage" class="alert d-none"></div>

        <form id="registrationForm">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required placeholder="user@strathmore.edu">
            </div>
            <div class="form-group">
                <label for="password">Password (min 8 characters)</label>
                <input type="password" id="password" name="password" required minlength="8">
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            <button type="submit">Register</button>
            <div class="login-link">
                Already have an account? <a href="Securityguardlogin.php">Login here</a>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('registrationForm').addEventListener('submit', async function (e) {
            e.preventDefault();

            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value;
            const confirm_password = document.getElementById('confirm_password').value;
            const messageBox = document.getElementById('responseMessage');

            if (password !== confirm_password) {
                messageBox.classList.remove('d-none', 'alert-success');
                messageBox.classList.add('alert-danger');
                messageBox.textContent = "Passwords do not match";
                return;
            }

            try {
                const response = await fetch(window.location.href, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        email,
                        password,
                        confirm_password
                    }),
                });

                const result = await response.json();

                messageBox.classList.remove('d-none', 'alert-success', 'alert-danger');
                if (result.success) {
                    messageBox.classList.add('alert-success');
                    messageBox.textContent = result.message;
                    setTimeout(() => {
                        window.location.href = 'Securityguardlogin.php'; // Redirect to login page
                    }, 2000);
                } else {
                    messageBox.classList.add('alert-danger');
                    messageBox.textContent = result.message;
                }
            } catch (error) {
                messageBox.classList.remove('d-none', 'alert-success');
                messageBox.classList.add('alert-danger');
                messageBox.textContent = 'Network error. Please try again.';
                console.error(error);
            }
        });
    </script>
</body>
</html>
