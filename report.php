<?php
session_start();
require_once("config/connect.php");

$successMessage = "";
$errorMessage = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ItemName = trim($_POST['item_name'] ?? '');
    $Category = trim($_POST['category'] ?? '');
    $Description = trim($_POST['description'] ?? '');
    $LocationLost = trim($_POST['location'] ?? '');
    $DateLost = $_POST['date_lost'] ?? null;
    $Email = trim($_POST['Email'] ?? '');
    $itemImage = null;

    if (
        empty($ItemName) || empty($Category) || empty($Description) ||
        empty($LocationLost) || empty($Email) || !str_ends_with($Email, '@strathmore.edu')
    ) {
        $errorMessage = "All fields except image are required. Email must be @strathmore.edu.";
    } else {
        if (!empty($_FILES['item_image']['name'])) {
            $uploadDir = "uploads/";
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $imageName = basename($_FILES["item_image"]["name"]);
            $itemImage = $uploadDir . time() . "_" . $imageName;

            if (!move_uploaded_file($_FILES["item_image"]["tmp_name"], $itemImage)) {
                $errorMessage = "Failed to upload image.";
            }
        }

        if (!$errorMessage) {
            $stmt = $conn->prepare("INSERT INTO LostItems (ItemName, Category, Description, LocationLost, DateLost, itemImage, Email) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssss", $ItemName, $Category, $Description, $LocationLost, $DateLost, $itemImage, $Email);

            if ($stmt->execute()) {
                $successMessage = "Lost item successfully submitted!";
            } else {
                $errorMessage = "Database error: " . $conn->error;
            }
        }
        $emailExists = $conn->prepare("SELECT 1 FROM Studentlogin WHERE Email = ?");
$emailExists->bind_param("s", $Email);
$emailExists->execute();
$result = $emailExists->get_result();

if ($result->num_rows === 0) {
    $errorMessage = "The provided email is not registered in the system.";
}
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Report Lost Item</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="container py-5">
  <h1 class="mb-4">Report Lost Item</h1>

  <?php if ($errorMessage): ?>
    <div class="alert alert-danger"><?php echo htmlspecialchars($errorMessage); ?></div>
  <?php elseif ($successMessage): ?>
    <div class="alert alert-success"><?php echo htmlspecialchars($successMessage); ?></div>
  <?php endif; ?>

  <form method="POST" enctype="multipart/form-data" class="row g-3">
    <div class="col-md-6">
      <label for="item_name" class="form-label">Item Name*</label>
      <input type="text" name="item_name" class="form-control" required>
    </div>

    <div class="col-md-6">
      <label for="category" class="form-label">Category*</label>
      <select name="category" class="form-select" required>
        <option value="">Choose...</option>
        <option value="Electronics">Electronics</option>
        <option value="Clothing">Clothing</option>
        <option value="Documents">Documents</option>
        <option value="Others">Others</option>
      </select>
    </div>

    <div class="col-md-12">
      <label for="description" class="form-label">Description*</label>
      <textarea name="description" class="form-control" rows="3" required></textarea>
    </div>

    <div class="col-md-6">
      <label for="location" class="form-label">Location Lost*</label>
      <input type="text" name="location" class="form-control" required>
    </div>

    <div class="col-md-6">
      <label for="date_lost" class="form-label">Date Lost*</label>
      <input type="datetime-local" name="date_lost" class="form-control" required>
    </div>

    <div class="col-md-6">
      <label for="item_image" class="form-label">Upload Image (optional)</label>
      <input type="file" name="item_image" class="form-control">
    </div>

    <div class="col-md-6">
      <label for="Email" class="form-label">Email*</label>
      <input type="email" name="Email" class="form-control" required placeholder="user@strathmore.edu">
    </div>

    <div class="col-12">
      <button type="submit" class="btn btn-primary w-100">Submit Lost Item</button>
    </div>
  </form>
</body>
</html>