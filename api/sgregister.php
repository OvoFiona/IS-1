<?php
// Enable error reporting for debugging (remove in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// CORS headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

header("Content-Type: application/json");
require_once("../config/connect.php"); // Adjust path to your DB config

$data = json_decode(file_get_contents("php://input"), true);

if (!$data || !isset($data['email'], $data['password'], $data['confirm_password'])) {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "Missing required fields"]);
    exit;
}

$email = trim($data['email']);
$password = $data['password'];
$confirmPassword = $data['confirm_password'];

// Basic validation
if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !str_ends_with($email, '@strathmore.edu')) {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "Invalid Strathmore email"]);
    exit;
}

if (strlen($password) < 8) {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "Password must be at least 8 characters long"]);
    exit;
}

if ($password !== $confirmPassword) {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "Passwords do not match"]);
    exit;
}

// Check for duplicate email
$stmt = $conn->prepare("SELECT id FROM securityguardlogin WHERE Email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    http_response_code(409);
    echo json_encode(["success" => false, "message" => "Email already registered"]);
    exit;
}
$stmt->close();

// Insert new user
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
$insert = $conn->prepare("INSERT INTO securityguardlogin (Email, password, created, updated) VALUES (?, ?, NOW(), NOW())");
$insert->bind_param("ss", $email, $hashedPassword);

if ($insert->execute()) {
    echo json_encode(["success" => true, "message" => "Registration successful"]);
} else {
    http_response_code(500);
    echo json_encode(["success" => false, "message" => "Database error: " . $insert->error]);
}


$insert->close();
$conn->close();
?>
