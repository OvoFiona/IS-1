<?php


// Handle verification actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $itemId = $_POST['item_id'];
    $action = $_POST['action'];
    $notes = $_POST['notes'] ?? '';
    $guardId = $_SESSION['user_id']; // Assuming guard is logged in

    try {
        if ($action === 'verify') {
            $stmt = $db->prepare("UPDATE found_items 
                                 SET verification_status = 'verified',
                                     verified_by = ?,
                                     verification_notes = ?,
                                     date_verified = NOW()
                                 WHERE id = ?");
            $stmt->execute([$guardId, $notes, $itemId]);
            $_SESSION['success'] = "Item verified successfully!";
        } 
        elseif ($action === 'reject') {
            $stmt = $db->prepare("UPDATE found_items 
                                 SET verification_status = 'rejected',
                                     verified_by = ?,
                                     verification_notes = ?,
                                     date_verified = NOW()
                                 WHERE id = ?");
            $stmt->execute([$guardId, $notes, $itemId]);
            $_SESSION['success'] = "Item rejected successfully!";
        }
        
        header("Location: guard_verify.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error updating item: " . $e->getMessage();
        header("Location: guard_verify.php");
        exit();
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Student Lost Items</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Verify Student Lost Items</h2>
        
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success"><?= $_SESSION['success'] ?></div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
        
        <div class="row">
            <?php if (empty($items)): ?>
                <div class="col-12">
                    <div class="alert alert-info">No items pending verification.</div>
                </div>
            <?php else: ?>
                <?php foreach ($items as $item): ?>
                    <div class="col-md-6 mb-4">
                        <div class="card h-100">
                            <?php if (!empty($item['image_path'])): ?>
                                <img src="<?= htmlspecialchars($item['image_path']) ?>" class="card-img-top" alt="<?= htmlspecialchars($item['item_name']) ?>" style="height: 300px; object-fit: cover;">
                            <?php else: ?>
                                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 300px;">No Image</div>
                            <?php endif; ?>
                            
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($item['item_name']) ?></h5>
                                <p><strong>Category:</strong> <?= htmlspecialchars($item['category']) ?></p>
                                <p><strong>Found at:</strong> <?= htmlspecialchars($item['location_found']) ?></p>
                                <p><strong>Found on:</strong> <?= date('M j, Y', strtotime($item['date_found'])) ?> at <?= htmlspecialchars($item['time_found']) ?></p>
                                <p><strong>Description:</strong> <?= htmlspecialchars($item['description'] ?: 'N/A') ?></p>
                                <p><strong>Reported by:</strong> <?= htmlspecialchars($item['reported_by_name']) ?> on <?= date('M j, Y g:i a', strtotime($item['date_reported'])) ?></p>
                                <p><strong>Storage:</strong> <?= htmlspecialchars($item['storage_location']) ?></p>
                            </div>
                            
                            <div class="card-footer bg-white">
                                <form method="POST" class="row g-3">
                                    <input type="hidden" name="item_id" value="<?= $item['id'] ?>">
                                    
                                    <div class="col-12">
                                        <label for="notes_<?= $item['id'] ?>" class="form-label">Verification Notes</label>
                                        <textarea class="form-control" id="notes_<?= $item['id'] ?>" name="notes" rows="2"></textarea>
                                    </div>
                                    
                                    <div class="col-6">
                                        <button type="submit" name="action" value="verify" class="btn btn-success w-100">
                                            <i class="bi bi-check-circle"></i> Verify
                                        </button>
                                    </div>
                                    
                                    <div class="col-6">
                                        <button type="submit" name="action" value="reject" class="btn btn-danger w-100">
                                            <i class="bi bi-x-circle"></i> Reject
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>