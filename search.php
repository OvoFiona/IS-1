<?php
require_once "config/connect.php";

$searchName = strtolower($_GET['itemName'] ?? '');
$searchDesc = strtolower($_GET['itemDescription'] ?? '');
$searchLocation = strtolower($_GET['lostLocation'] ?? '');
$searchDate = $_GET['lostDate'] ?? '';
$claimedSuccess = ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['claimed']) && $_GET['claimed'] === '1' && !isset($_SERVER['HTTP_REFERER']));



// Handle claim before any output
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['claimItem'])) {
    $itemId = intval($_POST['itemId']);
    $email = $_POST['email'];

    $update = $conn->prepare("UPDATE FoundItems SET StorageLocation = 'Claimed' WHERE Id = ? AND Email = ?");
    $update->bind_param("is", $itemId, $email);

    if ($update->execute()) {
        header("Location: " . $_SERVER['PHP_SELF'] . "?claimed=1");
        exit();
    } else {
        echo "<script>alert('Failed to update claim.');</script>";
    }
}

$sql = "SELECT * FROM FoundItems WHERE StorageLocation IS NULL OR StorageLocation != 'Claimed'";
if ($searchName) $sql .= " AND LOWER(itemName) LIKE '%$searchName%'";
if ($searchDesc) $sql .= " AND LOWER(Description) LIKE '%$searchDesc%'";
if ($searchLocation) $sql .= " AND LOWER(LocationFound) LIKE '%$searchLocation%'";
if ($searchDate) $sql .= " AND DateFound LIKE '$searchDate%'";
$sql .= " ORDER BY DateFound DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lost and Found Search</title>
    <link rel="stylesheet" href="CSS/search.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <header class="mt-4 mb-3">
            <h1>Lost and Found Dashboard</h1>
            <p>Search for your lost items on campus</p>
        </header>

        <section class="search-section mb-4">
            <h2>Search Filters</h2>
            <form method="GET" class="search-form row g-2">
                <div class="col-md-3">
                    <input type="text" name="itemName" class="form-control" placeholder="Item name" value="<?= htmlspecialchars($searchName) ?>">
                </div>
                <div class="col-md-3">
                    <input type="text" name="itemDescription" class="form-control" placeholder="Description" value="<?= htmlspecialchars($searchDesc) ?>">
                </div>
                <div class="col-md-3">
                    <input type="text" name="lostLocation" class="form-control" placeholder="Where lost" value="<?= htmlspecialchars($searchLocation) ?>">
                </div>
                <div class="col-md-3">
                    <input type="date" name="lostDate" class="form-control" value="<?= htmlspecialchars($searchDate) ?>">
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </form>
        </section>

        <?php if ($claimedSuccess): ?>
            <div class="alert alert-success">Item successfully claimed.</div>
        <?php endif; ?>

        <section class="dashboard mt-4" id="itemsDashboard">
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($item = $result->fetch_assoc()): ?>
                    <div class="item-card border rounded p-3 mb-3 shadow-sm">
                        <img src="<?= $item['itemImage'] ?: 'images/default.png' ?>" alt="<?= htmlspecialchars($item['itemName']) ?>" class="item-image mb-2" style="max-height: 150px;">
                        <div class="item-details">
                            <h5 class="item-name"><?= htmlspecialchars($item['itemName']) ?></h5>
                            <p class="item-description"><?= htmlspecialchars($item['Description']) ?></p>
                            <p class="item-meta">
                                <strong>Lost at:</strong> <?= htmlspecialchars($item['LocationFound']) ?><br>
                                <strong>Date:</strong> <?= date("M d, Y", strtotime($item['DateFound'])) ?>
                            </p>
                            <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
                                <input type="hidden" name="itemId" value="<?= $item['Id'] ?>">
                                <input type="hidden" name="email" value="<?= htmlspecialchars($item['Email']) ?>">
                                <button class="btn btn-success mt-2" name="claimItem">Claim Item</button>
                            </form>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="alert alert-warning">No items found matching your search criteria.</div>
            <?php endif; ?>
        </section>

        <div class="d-flex gap-2 mt-4">
            <a href="dashboard.html" class="btn btn-success btn-sm">Back to Dashboard</a>
            <a href="index.php" class="btn btn-dark btn-sm">Home</a>
        </div>
    </div>
</body>
</html>
