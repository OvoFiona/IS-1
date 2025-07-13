<?php
require_once "config/connect.php";
session_start();



$studentEmail = $_SESSION['email'];

$stmt = $conn->prepare("SELECT ItemName, verification_status, verification_notes, date_verified FROM lostitems WHERE Email = ? AND verification_status IS NOT NULL ORDER BY date_verified DESC");
$stmt->bind_param("s", $studentEmail);
$stmt->execute();
$result = $stmt->get_result();
$notifications = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Notifications</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f8;
        }
        .notification-card {
            transition: box-shadow 0.2s ease;
        }
        .notification-card:hover {
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .badge-status {
            font-size: 0.75rem;
        }
    </style>
</head>
<body>
<div class="container py-5">
    <h2 class="text-center mb-4">My Notifications</h2>

    <?php if (empty($notifications)): ?>
        <div class="alert alert-info text-center">You have no notifications.</div>
    <?php else: ?>
        <div class="row">
            <?php foreach ($notifications as $note): ?>
                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="card notification-card">
                        <div class="card-body">
                            <p class="card-text">
                                Your claim for <strong><?= htmlspecialchars($note['ItemName']) ?></strong> was
                                <strong class="text-<?= $note['verification_status'] === 'verified' ? 'success' : 'danger' ?>">
                                    <?= htmlspecialchars($note['verification_status']) ?>
                                </strong>.
                            </p>
                            <?php if (!empty($note['verification_notes'])): ?>
                                <p class="text-muted small">Note: <?= htmlspecialchars($note['verification_notes']) ?></p>
                            <?php endif; ?>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    Verified on: <?= date("M j, Y g:i a", strtotime($note['date_verified'])) ?>
                                </small>
                                <span class="badge bg-success badge-status">Delivered</span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

     <div class="d-flex gap-2 mt-4">
  <a href="dashboard.html" class="btn btn-success btn-sm">Back to Dashboard</a>
  <a href="index.php" class="btn btn-dark btn-sm">Home</a>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
