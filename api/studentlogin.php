<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");
require_once "../config/connect.php";

session_start();

// Get JSON input
$data = json_decode(file_get_contents('php://input'), true);

// Validate input
if (empty($data['strathmoreEmail']) || empty($data['password'])) {
    http_response_code(400);
    echo json_encode(["error" => "Email and password are required"]);
    exit;
}

$email = $data['strathmoreEmail'];
$password = $data['password'];

try {
    $stmt = $conn->prepare("SELECT studentId, password FROM Studentlogin WHERE strathmoreEmail = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        http_response_code(401);
        echo json_encode(["error" => "Invalid credentials"]);
        exit;
    }
    
    $user = $result->fetch_assoc();
    
    if (password_verify($password, $user['password'])) {
        // Login successful
        $_SESSION['studentId'] = $user['studentId'];
        $_SESSION['email'] = $email;
        
        echo json_encode([
            "success" => true,
            "studentId" => $user['studentId'],
            "email" => $email
        ]);
    } else {
        http_response_code(401);
        echo json_encode(["error" => "Invalid credentials"]);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => "Server error"]);
}

$conn->close();
?>