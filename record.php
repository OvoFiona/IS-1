<?php
require_once("config/connect.php");

$successMessage = "";
$errorMessage = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ItemName = trim($_POST['item_name'] ?? '');
    $LocationFound = trim($_POST['location_found'] ?? '');
    $LocationLost = trim($_POST['location_lost'] ?? '');
    $DateFound = $_POST['date_found'] ?? '';
    $DateLost = $_POST['date_lost'] ?? '';
    $Description = trim($_POST['description'] ?? '');
    $Email = trim($_POST['Email'] ?? '');
    $DateClaimed = $_POST['date_claimed'] ?? '';
    $Status = $_POST['status'] ?? 'Unclaimed';

    // Validation
    if (
        empty($ItemName) || empty($LocationFound) || empty($LocationLost) ||
        empty($DateFound) || empty($DateLost) || empty($Email) || empty($Status)
    ) {
        $errorMessage = "Please fill in all required fields.";
    } else {
        try {
            $stmt = $conn->prepare("INSERT INTO Records (ItemName, LocationFound, LocationLost, DateFound, DateLost, Description, Email, DateClaimed, Status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssssss", $ItemName, $LocationFound, $LocationLost, $DateFound, $DateLost, $Description, $Email, $DateClaimed, $Status);

            if ($stmt->execute()) {
                $successMessage = "Item recorded successfully.";
            } else {
                $errorMessage = "Database error: " . $stmt->error;
            }
        } catch (Exception $e) {
            $errorMessage = "Server error: " . $e->getMessage();
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
    <title>Record Found Item</title>
   <link rel="stylesheet" href="CSS/record.css">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
   
</head>
<body>
    <h1>Record Found Item</h1>
    <form method="POST">
    <label for="item_name">Item Name:</label>
    <input type="text" id="item_name" name="item_name" required>

    <label for="location_found">Location Found:</label>
    <input type="text" id="location_found" name="location_found" required>

    <label for="location_lost">Location Lost:</label>
    <input type="text" id="location_lost" name="location_lost" required>

    <label for="date_found">Date Found:</label>
    <input type="datetime-local" id="date_found" name="date_found" required>

    <label for="date_lost">Date Lost:</label>
    <input type="datetime-local" id="date_lost" name="date_lost" required>

    <label for="description">Description:</label>
    <textarea id="description" name="description" rows="4"></textarea>

    <label for="Email">Email:</label>
    <input type="email" id="Email" name="Email" required placeholder="email@strathmore.edu">

    <label for="date_claimed">Date Claimed (optional):</label>
    <input type="datetime-local" id="date_claimed" name="date_claimed">

    <label for="status">Status:</label>
    <select id="status" name="status" required>
        <option value="">Choose...</option>
        <option value="Unclaimed">Unclaimed</option>
        <option value="Claimed">Claimed</option>    
    </select>

    <button type="submit">Submit</button>
</form>


       
        
    </form>
    <p><a href="view.php">View All Items</a></p>

  
</form>
</body>
</html>