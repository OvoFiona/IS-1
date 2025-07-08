<?php
require_once("../config/connect.php"); // Adjust if needed

header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && strpos($_SERVER["CONTENT_TYPE"], "application/json") !== false) {
    $data = json_decode(file_get_contents("php://input"), true);

    // Extract and validate fields
    $itemName = trim($data['ItemName'] ?? '');
    $description = trim($data['Description'] ?? '');
    $locationLost = trim($data['LocationLost'] ?? '');
    $itemImage = trim($data['itemImage'] ?? '');// Optional field
    $email = trim($data['Email'] ?? '');
    $dateLost = trim($data['DateLost'] ?? ''); 

    // Validate required fields
    if (empty($itemName) || empty($description) || empty($locationLost) || empty($email) || empty($dateLost)) {
        echo json_encode(['success' => false, 'message' => 'All required fields must be filled.']);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'Invalid email format.']);
        exit;
    }

    // Validate date format if provided
    if (!empty($dateLost) && !DateTime::createFromFormat('Y-m-d H:i:s', $dateLost)) {
        echo json_encode(['success' => false, 'message' => 'DateLost must be in YYYY-MM-DD HH:MM:SS format.']);
        exit;
    }

    // Check if student email exists
    $checkStmt = $conn->prepare("SELECT Email FROM StudentLogin WHERE Email = ?");
    $checkStmt->bind_param("s", $email);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows === 0) {
        echo json_encode(['success' => false, 'message' => 'No registered student found with that email.']);
        $checkStmt->close();
        exit;
    }
    $checkStmt->close();

    // Insert lost item
    if (!empty($dateLost)) {
        $stmt = $conn->prepare("INSERT INTO LostItems (ItemName, Description, LocationLost, DateLost, itemImage, Email) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $itemName, $description, $locationLost, $dateLost, $itemImage, $email);
    } else {
        $stmt = $conn->prepare("INSERT INTO LostItems (ItemName, Description, LocationLost, itemImage, Email) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $itemName, $description, $locationLost, $itemImage, $email);
    }

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Lost item reported successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error reporting item: ' . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method or content type.']);
}
