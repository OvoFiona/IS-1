<?php
require_once("config/connect.php");
require_once("config/constants.php");

// Handle delete action
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM Records WHERE Id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header("Location: view.php");
    exit();
}

$sql = "SELECT Id, ItemName, LocationFound, LocationLost, DateFound, DateLost, Description, Email, DateClaimed, Status FROM Records ORDER BY Id DESC";
$result = $conn->query($sql);
$records = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $records[] = $row;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Found Items</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h1 class="mb-4 text-center">Found Items</h1>
    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Item Name</th>
                <th>Location Found</th>
                <th>Location Lost</th>
                <th>Date Found</th>
                <th>Date Lost</th>
                <th>Description</th>
                <th>Status</th>
                <th>Claimed By</th>
                <th>Date Claimed</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php if (!empty($records)) : ?>
            <?php foreach ($records as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['Id']) ?></td>
                    <td><?= htmlspecialchars($item['ItemName']) ?></td>
                    <td><?= htmlspecialchars($item['LocationFound']) ?></td>
                    <td><?= htmlspecialchars($item['LocationLost']) ?></td>
                    <td><?= htmlspecialchars($item['DateFound']) ?></td>
                    <td><?= htmlspecialchars($item['DateLost']) ?></td>
                    <td><?= htmlspecialchars($item['Description']) ?></td>
                    <td><?= htmlspecialchars($item['Status']) ?></td>
                    <td><?= htmlspecialchars($item['Email']) ?></td>
                    <td><?= htmlspecialchars($item['DateClaimed'] ?? 'N/A') ?></td>
                    <td>
                        <a href="edit.php?id=<?= $item['Id'] ?>" class="btn btn-sm btn-primary">Edit</a>
                        <a href="view.php?delete=<?= $item['Id'] ?>" onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="11" class="text-center">No records found</td></tr>
        <?php endif; ?>
        </tbody>
    </table>

    <p><a href="sgdashboard.php">Back to Dashboard</a></p>
    <p><a href="record.php">Record New Item</a></p>
</div>
</body>
</html>
