<?php
require_once("../config/connect.php"); // Adjust path as needed

// Read and decode the JSON body
$data = json_decode(file_get_contents("php://input"), true);

// Validate input
if (!isset($data['email'], $data['password'], $data['confirm_password'])) {
    echo json_encode(["success" => false, "message" => "All fields are required."]);
    exit;
}

$email = trim($data['email']);
$password = $data['password'];
$confirm_password = $data['confirm_password'];

// Basic validations
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(["success" => false, "message" => "Invalid email format."]);
    exit;
}

if (!str_ends_with($email, '@strathmore.edu')) {
    echo json_encode(["success" => false, "message" => "Only Strathmore University emails allowed."]);
    exit;
}

if (strlen($password) < 8) {
    echo json_encode(["success" => false, "message" => "Password must be at least 8 characters."]);
    exit;
}

if ($password !== $confirm_password) {
    echo json_encode(["success" => false, "message" => "Passwords do not match."]);
    exit;
}

// Check if email already exists
$stmt = $conn->prepare("SELECT Email FROM securityguardlogin WHERE Email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo json_encode(["success" => false, "message" => "Email is already registered."]);
    exit;
}
$stmt->close();

// Hash password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Insert user
$stmt = $conn->prepare("INSERT INTO securityguardlogin (Email, Password) VALUES (?, ?)");
$stmt->bind_param("ss", $email, $hashedPassword);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Registration successful!"]);
} else {
    echo json_encode(["success" => false, "message" => "Database error: Unable to register."]);
}

$stmt->close();
$conn->close();
?>
