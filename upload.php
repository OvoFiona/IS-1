<?php
require_once("config/connect.php");

$successMessage = "";
$errorMessage = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $itemName = trim($_POST['itemName'] ?? '');
    $category = trim($_POST['Category'] ?? '');
    $locationFound = trim($_POST['LocationFound'] ?? '');
    $dateFound = $_POST['DateFound'] ?? '';
    $description = trim($_POST['Description'] ?? '');
    $email = trim($_POST['Email'] ?? '');
    $storageLocation = trim($_POST['StorageLocation'] ?? '');

    // Validation
    if (empty($itemName) || empty($category) || empty($locationFound) || empty($dateFound) || empty($email)) {
        $errorMessage = "Please fill in all required fields.";
    } else {
        $imagePath = null;
        if (!empty($_FILES['itemImage']['name'])) {
            $uploadsDir = 'uploads/';
            if (!file_exists($uploadsDir)) {
                mkdir($uploadsDir, 0777, true);
            }
            $filename = time() . "_" . basename($_FILES['itemImage']['name']);
            $targetPath = $uploadsDir . $filename;
            if (move_uploaded_file($_FILES['itemImage']['tmp_name'], $targetPath)) {
                $imagePath = $targetPath;
            } else {
                $errorMessage = "Image upload failed.";
            }
        }

        if (empty($errorMessage)) {
            try {
                $stmt = $conn->prepare("INSERT INTO FoundItems (itemName, Category, LocationFound, DateFound, Description, itemImage, Email, StorageLocation) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("ssssssss", $itemName, $category, $locationFound, $dateFound, $description, $imagePath, $email, $storageLocation);

                if ($stmt->execute()) {
                    $successMessage = "Item recorded successfully.";
                } else {
                    $errorMessage = "Database error: " . $stmt->error;
                }
                $stmt->close();
            } catch (Exception $e) {
                $errorMessage = "Server error: " . $e->getMessage();
            }
        }
    }
}

if (!empty($successMessage)) {
    echo "<div class='alert alert-success'>$successMessage</div>";
} elseif (!empty($errorMessage)) {
    echo "<div class='alert alert-danger'>$errorMessage</div>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Found Item - Security Guard Portal</title>
    <link rel="stylesheet" href="CSS/upload.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h1>Upload Found Item</h1>
    <form id="foundItemForm" enctype="multipart/form-data" method="POST">
        <div class="form-group">
            <label for="itemName" class="required">itemName</label>
            <input type="text" id="itemName" name="itemName" required>
        </div>

        <div class="form-group">
            <label for="Category" class="required">Category</label>
            <select id="category" name="Category" required>
                <option value="">Select a category</option>
                <option value="electronics">Electronics</option>
                <option value="documents">Documents</option>
                <option value="clothing">Clothing</option>
                <option value="accessories">Accessories</option>
                <option value="valuables">Valuables</option>
                <option value="other">Other</option>
            </select>
        </div>

        <div class="form-group">
            <label for="LocationFound" class="required">LocationFound</label>
            <input type="text" id="LocationFound" name="LocationFound" required>
        </div>

        <div class="form-group">
            <label for="DateFound" class="required">DateFound</label>
            <input type="datetime-local" id="DateFound" name="DateFound" required>
        </div>

        <div class="form-group">
            <label for="Description">Description</label>
            <textarea id="Description" name="Description"></textarea>
        </div>

        <div class="form-group">
            <label for="itemImage">itemImage</label>
            <input type="file" id="itemImage" name="itemImage" accept="image/*">
        </div>

        <div class="form-group">
            <label for="Email">Email</label>
            <input type="email" id="Email" name="Email" required>
        </div>

        <div class="form-group">
            <label for="StorageLocation">StorageLocation</label>
            <input type="text" id="StorageLocation" name="StorageLocation">
        </div>

        <button type="submit">Submit Found Item</button>
    </form>
</div>

<script>
    document.getElementById('imageUpload').addEventListener('change', function(e) {
        const preview = document.getElementById('imagePreview');
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(this.files[0]);
        }
    });
</script>
</body>
</html>
