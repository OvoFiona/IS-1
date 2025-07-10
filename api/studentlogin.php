<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

require_once "../config/connect.php";
session_start();

$data = json_decode(file_get_contents('php://input'), true);

if (empty($data['email']) || empty($data['password'])) {
    http_response_code(400);
    echo json_encode(["success" => false, "error" => "Email and password are required"]);
    exit;
}

$email = $data['email'];
$password = $data['password'];

try {
   $stmt = $conn->prepare('SELECT Id, password FROM Studentlogin WHERE Email = ?');
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        http_response_code(401);
        echo json_encode(["success" => false, "error" => "Invalid credentials"]);
        exit;
    }

    $user = $result->fetch_assoc();

    if (password_verify($password, $user['password'])) {
        $_SESSION['studentId'] = $user['Id'];
        $_SESSION['email'] = $email;

        echo json_encode([
            "success" => true,
            "studentId" => $user['Id'],
            "email" => $email
        ]);
    } else {
        http_response_code(401);
        echo json_encode(["success" => false, "error" => "Invalid credentials"]);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["success" => false, "error" => "Server error"]);
}

$conn->close();
?>
