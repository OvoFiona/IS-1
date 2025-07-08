<?php
// report.php
// This file handles the lost item reporting form for Strathmore University.
session_start();
require_once("config/connect.php");

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $itemName = trim($_POST['itemName'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $Description = trim($_POST['Description'] ?? '');
    $LocationLost = trim($_POST['LocationLost'] ?? '');
    $dateLost = trim($_POST['dateLost'] ?? '');
    $Email = trim($_POST['Email'] ?? '');
    $itemImage = trim($_POST['itemImage']?? ''); // Initialize itemImage variable


    
    // Validate required fields
    if (empty($itemName) || empty($Category) || empty($Description) || empty($LocationLost) || empty($Email) || empty($dateLost) || empty($itemImage)) {
        $errorMessage = "All fields marked with * are required.";
    } elseif (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
        $errorMessage = "Invalid email format.";
    } else {
        // Handle file upload if an image is provided
        $imageUrl = '';
        if (isset($_FILES['itemImage']) && $_FILES['itemImage']['error'] === UPLOAD_ERR_OK) {
            $targetDir = "uploads/";
            $targetFile = $targetDir . basename($_FILES["itemImage"]["name"]);
            if (move_uploaded_file($_FILES["itemImage"]["tmp_name"], $targetFile)) {
                $imageUrl = $targetFile; // Store the image URL
            } else {
                $errorMessage = "Error uploading image.";
            }
        }

        // Insert into database
        $stmt = $conn->prepare("INSERT INTO LostItems (ItemName, Category, Description, LocationLost, DateLost, itemImage, Email) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $itemName, $Category, $Description, $locationLost, $DateLost, $itemImage, $Email);
        
        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Lost item reported successfully.";
            header("Location: dashboard.html"); // Redirect to student page after successful submission
            exit();
        } else {
            $errorMessage = "Error reporting lost item: " . $stmt->error;
        }
        
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Strathmore University - Report Lost Item</title>
    <link rel="stylesheet" href="CSS/report.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    
    
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Report Lost Item</h1>
            <p>Strathmore University Lost & Found System</p>
        </div>
        
        <div class="report-form">
            <form id="lostItemForm">
                <div class="form-group">
                    <label for="item_name">Item Name*</label>
                    <input type="text" id="item_name" name="item_name" required>
                </div>
                
                <div class="form-group">
                    <label for="category">Category*</label>
                    <select id="category" name="category" required>
                        <option value="">Select category</option>
                        <option value="electronics">Electronics</option>
                        <option value="documents">Documents</option>
                        <option value="clothing">Clothing</option>
                        <option value="accessories">Accessories</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="description">Description*</label>
                    <textarea id="Description" name="Description" required></textarea>
                </div>
                
                <div class="form-group">
                    <label for="location">LocationLost*</label>
                    <input type="text" id="LocationLost" name="LocationLost" required>
                </div>
                
                <div class="form-group">
                    <label for="date_lost">DateLost*</label>
                    <input type="date" id="DateLost" name="DateLost" required>
                </div>
                
                <div class="form-group">
                <label>Image (Optional)</label>
                <div class="image-upload" id="imageUploadArea">
                    <div class="upload-icon">📷</div>
                    <p>Click to upload an image or drag & drop</p>
                    <input type="file" id="itemImage" name="itemImage" accept="image/*" style="display: none;">
                    <img id="imagePreview" class="image-preview" alt="Image preview">
                </div>
            </div>
              
                           
                <div class="form-group">
                    <label for="email">Email*</label>
                    <input type="email" id="email" name="email" required placeholder="username@strathmore.edu">
                </div>
                
                <button id="reportButton">Report Lost Item</button>

                <div id="statusMessage" class="status-message">
                <span class="success-icon">✓</span>
                <span id="messageText"></span>
            </div>
            </form>
        </div>
           <script>
            

           </script> 
         

    <script src="report.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous"></script>
   
</body>
</html>