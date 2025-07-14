<?php
require_once "config/connect.php";
session_start();

$studentEmail = $_SESSION['email'] ?? '';

$stmt = $conn->prepare("
    SELECT ItemName, verification_status, verification_notes, date_verified 
    FROM lostitems 
    WHERE Email = ? AND verification_status IS NOT NULL 
    ORDER BY date_verified DESC
");
$stmt->bind_param("s", $studentEmail);
$stmt->execute();
$result = $stmt->get_result();
$notifications = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Notifications</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
        }
        .notification-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            transition: transform 0.2s ease;
        }
        .notification-card:hover {
            transform: translateY(-3px);
        }
        .badge-status {
            font-size: 0.75rem;
        }
        .text-verified {
            color: #28a745;
            font-weight: 600;
        }
        .text-rejected {
            color: #dc3545;
            font-weight: 600;
        }
        .section-title {
            color: #2c3e50;
        }
    </style>
</head>
<body>

<div class="container py-5">
    <h2 class="text-center section-title mb-4">My Notifications</h2>

    <?php if (empty($notifications)): ?>
        <div class="alert alert-warning text-center shadow-sm">You have no notifications yet.</div>
    <?php else: ?>
        <div class="row">
            <?php foreach ($notifications as $note): ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card notification-card">
                        <div class="card-body">
                            <h5 class="card-title mb-2"><?= htmlspecialchars($note['ItemName']) ?></h5>
                            <p class="card-text mb-1">
                                Status:
                                <span class="<?= $note['verification_status'] === 'verified' ? 'text-verified' : 'text-rejected' ?>">
                                    <?= ucfirst(htmlspecialchars($note['verification_status'])) ?>
                                </span>
                            </p>
                            <?php if (!empty($note['verification_notes'])): ?>
                                <p class="text-muted small mb-2">Note: <?= htmlspecialchars($note['verification_notes']) ?></p>
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

    <div class="d-flex justify-content-center gap-3 mt-4">
        <a href="dashboard.html" class="btn btn-outline-success btn-sm px-4">Back to Dashboard</a>
        <a href="index.php" class="btn btn-outline-dark btn-sm px-4">Home</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
