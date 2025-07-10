<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("../config/connect.php"); // Adjust if needed

header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Use multipart/form-data for file upload
    $itemName = trim($_POST['itemName'] ?? '');
    $Description = trim($_POST['Description'] ?? '');
    $Category = trim($_POST['category'] ?? '');
    $LocationLost = trim($_POST['LocationLost'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $DateLost = trim($_POST['DateLost'] ?? '');
    // Convert date from Y-m-d (from input type="date") to MySQL DATETIME format (Y-m-d H:i:s)
    if (!empty($DateLost)) {
        $dateObj = DateTime::createFromFormat('Y-m-d', $DateLost);
        if ($dateObj) {
            $DateLost = $dateObj->format('Y-m-d H:i:s');
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid date format. Use YYYY-MM-DD.']);
            exit;
        }
    }
    $itemImage = '';
    if (isset($_FILES['itemImage']) && $_FILES['itemImage']['error'] === UPLOAD_ERR_OK) {
        $targetDir = '../uploads/';
        if (!is_dir($targetDir)) { mkdir($targetDir, 0777, true); }
        $targetFile = $targetDir . basename($_FILES['itemImage']['name']);
        if (move_uploaded_file($_FILES['itemImage']['tmp_name'], $targetFile)) {
            $itemImage = $targetFile;
        } else {
            echo json_encode(['success' => false, 'message' => 'Error uploading image.']);
            exit;
        }
    }

    // Validate required fields
    if (empty($itemName) || empty($Description) || empty($Category) || empty($LocationLost) || empty($email) || empty($DateLost)) {
        echo json_encode(['success' => false, 'message' => 'All required fields must be filled.']);
        exit;
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'Invalid email format.']);
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
    $stmt = $conn->prepare("INSERT INTO LostItems (ItemName, Description, Category, LocationLost, DateLost, itemImage, Email) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $itemName, $Description, $Category, $LocationLost, $DateLost, $itemImage, $email);
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Lost item reported successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error reporting item: ' . $stmt->error]);
    }
    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
