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

// Handle update action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_id'])) {
    $stmt = $conn->prepare("UPDATE Records SET ItemName=?, LocationFound=?, LocationLost=?, DateFound=?, DateLost=?, Description=?, Email=?, DateClaimed=?, Status=? WHERE Id=?");
    $stmt->bind_param("sssssssssi",
        $_POST['item_name'], $_POST['location_found'], $_POST['location_lost'],
        $_POST['date_found'], $_POST['date_lost'], $_POST['description'],
        $_POST['email'], $_POST['date_claimed'], $_POST['status'], $_POST['edit_id']
    );
    $stmt->execute();
    $stmt->close();
    header("Location: view.php");
    exit();
}

$editId = $_GET['edit'] ?? null;
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
                    <?php if ($editId == $item['Id']): ?>
                        <form method="POST">
                            <input type="hidden" name="edit_id" value="<?= $item['Id'] ?>">
                            <td><?= $item['Id'] ?></td>
                            <td><input name="item_name" value="<?= htmlspecialchars($item['ItemName']) ?>" class="form-control"></td>
                            <td><input name="location_found" value="<?= htmlspecialchars($item['LocationFound']) ?>" class="form-control"></td>
                            <td><input name="location_lost" value="<?= htmlspecialchars($item['LocationLost']) ?>" class="form-control"></td>
                            <td><input type="datetime-local" name="date_found" value="<?= htmlspecialchars($item['DateFound']) ?>" class="form-control"></td>
                            <td><input type="datetime-local" name="date_lost" value="<?= htmlspecialchars($item['DateLost']) ?>" class="form-control"></td>
                            <td><input name="description" value="<?= htmlspecialchars($item['Description']) ?>" class="form-control"></td>
                            <td>
                                <select name="status" class="form-control">
                                    <option value="Unclaimed" <?= $item['Status'] === 'Unclaimed' ? 'selected' : '' ?>>Unclaimed</option>
                                    <option value="Claimed" <?= $item['Status'] === 'Claimed' ? 'selected' : '' ?>>Claimed</option>
                                </select>
                            </td>
                            <td><input name="email" value="<?= htmlspecialchars($item['Email']) ?>" class="form-control"></td>
                            <td><input type="datetime-local" name="date_claimed" value="<?= htmlspecialchars($item['DateClaimed']) ?>" class="form-control"></td>
                            <td class="d-flex gap-1">
                                <button type="submit" class="btn btn-sm btn-success">Save</button>
                                <a href="view.php" class="btn btn-sm btn-secondary">Cancel</a>
                            </td>
                        </form>
                    <?php else: ?>
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
                            <a href="view.php?edit=<?= $item['Id'] ?>" class="btn btn-sm btn-primary">Edit</a>
                            <a href="view.php?delete=<?= $item['Id'] ?>" onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">Delete</a>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="11" class="text-center">No records found</td></tr>
        <?php endif; ?>
        </tbody>
    </table>

    <div class="d-flex gap-2 mt-3">
        <a href="sgdashboard.php" class="btn btn-success btn-sm">Back to Dashboard</a>
        <a href="record.php" class="btn btn-warning btn-sm">Record New Item</a>
    </div>
</div>
</body>
</html>
