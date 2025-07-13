<?php
require_once "config/connect.php";
session_start();

$conn->query("ALTER TABLE LostItems ADD COLUMN IF NOT EXISTS verification_status VARCHAR(50)");
$conn->query("ALTER TABLE LostItems ADD COLUMN IF NOT EXISTS verification_notes TEXT");
$conn->query("ALTER TABLE LostItems ADD COLUMN IF NOT EXISTS date_verified DATETIME");
$conn->query("CREATE TABLE IF NOT EXISTS Notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_email VARCHAR(255),
    message TEXT,
    is_read BOOLEAN DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

// Handle inline form submission without redirection
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $itemId = $_POST['item_id'];
    $action = $_POST['action'];
    $notes = $_POST['notes'] ?? '';

    try {
        $status = $action === 'verify' ? 'verified' : 'rejected';
        $stmt = $conn->prepare("UPDATE LostItems SET verification_status = ?, verification_notes = ?, date_verified = NOW() WHERE Id = ?");
        $stmt->bind_param("ssi", $status, $notes, $itemId);
        $stmt->execute();

        // Fetch the email of the reporter for notification
        $emailStmt = $conn->prepare("SELECT Email, ItemName FROM LostItems WHERE Id = ?");
        $emailStmt->bind_param("i", $itemId);
        $emailStmt->execute();
        $result = $emailStmt->get_result()->fetch_assoc();

        if ($result && $result['Email']) {
            $msg = "Your item '{$result['ItemName']}' has been {$status}.";
            $notifStmt = $conn->prepare("INSERT INTO Notifications (user_email, message) VALUES (?, ?)");
            $notifStmt->bind_param("ss", $result['Email'], $msg);
            $notifStmt->execute();
        }

        $_SESSION['success'] = "Item {$status} successfully!";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } catch (Exception $e) {
        $_SESSION['error'] = "Error updating item: " . $e->getMessage();
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}

$lostItems = [];
$lostQuery = "SELECT * FROM LostItems WHERE verification_status IS NULL OR verification_status = ''";
$lostResult = $conn->query($lostQuery);
if ($lostResult) {
    $lostItems = $lostResult->fetch_all(MYSQLI_ASSOC);
}
$items = $lostItems;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Student Lost Items</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        h2 {
            font-weight: 700;
            color: #333;
        }
        .item-card {
            transition: transform 0.2s ease-in-out;
        }
        .item-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        .card-title {
            font-size: 1.25rem;
            font-weight: 600;
        }
        .card-img-top {
            border-bottom: 1px solid #dee2e6;
        }
        .card-footer {
            border-top: 1px solid #dee2e6;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4 text-center">Verify Student Lost Items</h2>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success text-center"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger text-center"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <div class="row">
            <?php if (empty($items)): ?>
                <div class="col-12">
                    <div class="alert alert-info text-center">No items pending verification.</div>
                </div>
            <?php else: ?>
                <?php foreach ($items as $item): ?>
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card h-100 item-card">
                            <?php if (!empty($item['itemImage'])): ?>
                                <img src="<?php echo htmlspecialchars($item['itemImage']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($item['ItemName']); ?>" style="height: 250px; object-fit: cover;">
                            <?php else: ?>
                                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 250px;">No Image</div>
                            <?php endif; ?>

                            <div class="card-body">
                                <h5 class="card-title text-primary"><?php echo htmlspecialchars($item['ItemName']); ?></h5>
                                <p><strong>Category:</strong> <?php echo htmlspecialchars($item['Category']); ?></p>
                                <p><strong>Lost at:</strong> <?php echo htmlspecialchars($item['LocationLost']); ?></p>
                                <p><strong>Date:</strong> <?php echo date('M j, Y', strtotime($item['DateLost'])); ?></p>
                                <p><strong>Description:</strong> <?php echo htmlspecialchars($item['Description'] ?: 'N/A'); ?></p>
                                <p><strong>Reported by:</strong> <?php echo htmlspecialchars($item['Email']); ?></p>
                            </div>

                            <div class="card-footer bg-white">
                                <form method="POST" class="row g-2">
                                    <input type="hidden" name="item_id" value="<?php echo $item['Id']; ?>">

                                    <div class="col-12">
                                        <label for="notes_<?php echo $item['Id']; ?>" class="form-label">Verification Notes</label>
                                        <textarea class="form-control" id="notes_<?php echo $item['Id']; ?>" name="notes" rows="2"></textarea>
                                    </div>

                                    <div class="col-6">
                                        <button type="submit" name="action" value="verify" class="btn btn-success w-100">
                                            Verify
                                        </button>
                                    </div>

                                    <div class="col-6">
                                        <button type="submit" name="action" value="reject" class="btn btn-danger w-100">
                                            Reject
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <div class="d-flex gap-2 mt-4">
  <a href="sgdashboard.php" class="btn btn-success btn-sm">Back to Dashboard</a>
  <a href="index.php" class="btn btn-dark btn-sm">Home</a>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
