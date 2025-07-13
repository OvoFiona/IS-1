<?php
require_once 'config/connect.php';

// Helper function to fetch all rows from a table
function fetchAll($conn, $table) {
    $result = mysqli_query($conn, "SELECT * FROM $table");
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// Handle CRUD actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Student CRUD
    if (isset($_POST['delete_student'])) {
        $id = intval($_POST['delete_student']);
        // Get student email
        $result = mysqli_query($conn, "SELECT Email FROM studentlogin WHERE Id='$id'");
        $row = mysqli_fetch_assoc($result);
        if ($row) {
            $email = $row['Email'];
            // Delete all lostitems referencing this email
            mysqli_query($conn, "DELETE FROM lostitems WHERE Email='$email'");
        }
        // Now delete the student
        mysqli_query($conn, "DELETE FROM studentlogin WHERE Id='$id'");
    }
    if (isset($_POST['add_student'])) {
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        mysqli_query($conn, "INSERT INTO studentlogin (Email, password, created, updated) VALUES ('$email', '$password', NOW(), NOW())");
    }
    if (isset($_POST['edit_student'])) {
        $id = intval($_POST['edit_student']);
        $email = $_POST['edit_email'];
        $password = $_POST['edit_password'] ? password_hash($_POST['edit_password'], PASSWORD_DEFAULT) : '';
        if ($password) {
            mysqli_query($conn, "UPDATE studentlogin SET Email='$email', password='$password', updated=NOW() WHERE Id='$id'");
        } else {
            mysqli_query($conn, "UPDATE studentlogin SET Email='$email', updated=NOW() WHERE Id='$id'");
        }
    }
    // Security Guard CRUD
    if (isset($_POST['delete_guard'])) {
        $id = intval($_POST['delete_guard']);
        mysqli_query($conn, "DELETE FROM securityguardlogin WHERE Id='$id'");
    }
    if (isset($_POST['add_guard'])) {
        $email = $_POST['guard_email'];
        $password = password_hash($_POST['guard_password'], PASSWORD_DEFAULT);
        mysqli_query($conn, "INSERT INTO securityguardlogin (Email, password, created, updated) VALUES ('$email', '$password', NOW(), NOW())");
    }
    if (isset($_POST['edit_guard'])) {
        $id = intval($_POST['edit_guard']);
        $email = $_POST['edit_guard_email'];
        $password = $_POST['edit_guard_password'] ? password_hash($_POST['edit_guard_password'], PASSWORD_DEFAULT) : '';
        if ($password) {
            mysqli_query($conn, "UPDATE securityguardlogin SET Email='$email', password='$password', updated=NOW() WHERE Id='$id'");
        } else {
            mysqli_query($conn, "UPDATE securityguardlogin SET Email='$email', updated=NOW() WHERE Id='$id'");
        }
    }
    // Records CRUD
    if (isset($_POST['delete_record'])) {
        $id = intval($_POST['delete_record']);
        mysqli_query($conn, "DELETE FROM records WHERE Id='$id'");
    }
    if (isset($_POST['add_record'])) {
        $item = $_POST['itemname'];
        $locfound = $_POST['locationfound'];
        $loclost = $_POST['locationlost'];
        $datefound = $_POST['datefound'];
        $datelost = $_POST['datelost'];
        $desc = $_POST['description'];
        $email = $_POST['record_email'];
        $dateclaimed = $_POST['dateclaimed'];
        $status = $_POST['status'];
        mysqli_query($conn, "INSERT INTO records (ItemName, LocationFound, LocationLost, DateFound, DateLost, Description, Email, DateClaimed, Status, CreatedAt, UpdatedAt) VALUES ('$item', '$locfound', '$loclost', '$datefound', '$datelost', '$desc', '$email', '$dateclaimed', '$status', NOW(), NOW())");
    }
    if (isset($_POST['edit_record'])) {
        $id = intval($_POST['edit_record']);
        $item = $_POST['edit_itemname'];
        $locfound = $_POST['edit_locationfound'];
        $loclost = $_POST['edit_locationlost'];
        $datefound = $_POST['edit_datefound'];
        $datelost = $_POST['edit_datelost'];
        $desc = $_POST['edit_description'];
        $email = $_POST['edit_record_email'];
        $dateclaimed = $_POST['edit_dateclaimed'];
        $status = $_POST['edit_status'];
        mysqli_query($conn, "UPDATE records SET ItemName='$item', LocationFound='$locfound', LocationLost='$loclost', DateFound='$datefound', DateLost='$datelost', Description='$desc', Email='$email', DateClaimed='$dateclaimed', Status='$status', UpdatedAt=NOW() WHERE Id='$id'");
    }
    // Lost Items CRUD
    if (isset($_POST['delete_lostitem'])) {
        $id = intval($_POST['delete_lostitem']);
        mysqli_query($conn, "DELETE FROM lostitems WHERE Id='$id'");
    }
    if (isset($_POST['add_lostitem'])) {
        $item = $_POST['lost_itemname'];
        $cat = $_POST['lost_category'];
        $desc = $_POST['lost_description'];
        $loclost = $_POST['lost_locationlost'];
        $datelost = $_POST['lost_datelost'];
        $img = $_POST['lost_itemimage'];
        $email = $_POST['lost_email'];
        $ver_status = $_POST['lost_verification_status'];
        $ver_notes = $_POST['lost_verification_notes'];
        $date_verified = $_POST['lost_date_verified'];
        mysqli_query($conn, "INSERT INTO lostitems (ItemName, Category, Description, LocationLost, DateLost, itemImage, Email, verification_status, verification_notes, date_verified) VALUES ('$item', '$cat', '$desc', '$loclost', '$datelost', '$img', '$email', '$ver_status', '$ver_notes', '$date_verified')");
    }
    if (isset($_POST['edit_lostitem'])) {
        $id = intval($_POST['edit_lostitem']);
        $item = $_POST['edit_lost_itemname'];
        $cat = $_POST['edit_lost_category'];
        $desc = $_POST['edit_lost_description'];
        $loclost = $_POST['edit_lost_locationlost'];
        $datelost = $_POST['edit_lost_datelost'];
        $img = $_POST['edit_lost_itemimage'];
        $email = $_POST['edit_lost_email'];
        $ver_status = $_POST['edit_lost_verification_status'];
        $ver_notes = $_POST['edit_lost_verification_notes'];
        $date_verified = $_POST['edit_lost_date_verified'];
        mysqli_query($conn, "UPDATE lostitems SET ItemName='$item', Category='$cat', Description='$desc', LocationLost='$loclost', DateLost='$datelost', itemImage='$img', Email='$email', verification_status='$ver_status', verification_notes='$ver_notes', date_verified='$date_verified' WHERE Id='$id'");
    }
    // Notifications CRUD
    if (isset($_POST['delete_notification'])) {
        $id = intval($_POST['delete_notification']);
        mysqli_query($conn, "DELETE FROM notifications WHERE id='$id'");
    }
    if (isset($_POST['edit_notification'])) {
        $id = intval($_POST['edit_notification']);
        $user_email = $_POST['edit_user_email'];
        $message = $_POST['edit_message'];
        $is_read = $_POST['edit_is_read'];
        $created_at = $_POST['edit_created_at'];
        mysqli_query($conn, "UPDATE notifications SET user_email='$user_email', message='$message', is_read='$is_read', created_at='$created_at' WHERE id='$id'");
    }
}

// Fetch all data
$students = fetchAll($conn, 'studentlogin');
$guards = fetchAll($conn, 'securityguardlogin');
$records = fetchAll($conn, 'records');
$lostitems = fetchAll($conn, 'lostitems');
$notifications = fetchAll($conn, 'notifications');

?>
<html>
<head>
    <title>System Admin Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; margin: 0; padding: 0; }
        h1 { background: #2c3e50; color: #fff; padding: 20px; margin: 0; }
        .container { padding: 20px; }
        table { border-collapse: collapse; width: 100%; margin-bottom: 30px; background: #fff; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background: #34495e; color: #fff; }
        tr:nth-child(even) { background: #f2f2f2; }
        .actions { display: flex; gap: 10px; }
        .btn { padding: 5px 10px; border: none; border-radius: 3px; cursor: pointer; }
        .btn-danger { background: #e74c3c; color: #fff; }
        .btn-success { background: #27ae60; color: #fff; }
        .btn-info { background: #2980b9; color: #fff; }
        form.inline { display: inline; }
        .add-form { margin-bottom: 20px; background: #ecf0f1; padding: 10px; border-radius: 5px; }
        .report { background: #fff; padding: 15px; border-radius: 5px; margin-bottom: 30px; }
    </style>
</head>
<body>
    <h1>System Admin Dashboard</h1>
    <div class="container">

        <h2>Students</h2>
        <form class="add-form" method="post">
            <input type="email" name="email" placeholder="Email" required>
            <input type="text" name="password" placeholder="Password" required>
            <button class="btn btn-success" name="add_student">Add Student</button>
        </form>
        <table>
            <tr>
                <th>Id</th><th>Email</th><th>Created</th><th>Updated</th><th>Actions</th>
            </tr>
            <?php foreach ($students as $student): ?>
            <tr>
                <form class="inline" method="post">
                <td><?= $student['Id'] ?></td>
                <td><input type="email" name="edit_email" value="<?= htmlspecialchars($student['Email']) ?>" required></td>
                <td><?= $student['created'] ?></td>
                <td><?= $student['updated'] ?></td>
                <td class="actions">
                    <input type="password" name="edit_password" placeholder="New Password">
                    <button class="btn btn-info" name="edit_student" value="<?= $student['Id'] ?>">Edit</button>
                    <button class="btn btn-danger" name="delete_student" value="<?= $student['Id'] ?>">Delete</button>
                </td>
                </form>
            </tr>
            <?php endforeach; ?>
        </table>


        <h2>Security Guards</h2>
        <form class="add-form" method="post">
            <input type="email" name="guard_email" placeholder="Email" required>
            <input type="text" name="guard_password" placeholder="Password" required>
            <button class="btn btn-success" name="add_guard">Add Guard</button>
        </form>
        <table>
            <tr>
                <th>Id</th><th>Email</th><th>Created</th><th>Updated</th><th>Actions</th>
            </tr>
            <?php foreach ($guards as $guard): ?>
            <tr>
                <form class="inline" method="post">
                <td><?= $guard['Id'] ?></td>
                <td><input type="email" name="edit_guard_email" value="<?= htmlspecialchars($guard['Email']) ?>" required></td>
                <td><?= $guard['created'] ?></td>
                <td><?= $guard['updated'] ?></td>
                <td class="actions">
                    <input type="password" name="edit_guard_password" placeholder="New Password">
                    <button class="btn btn-info" name="edit_guard" value="<?= $guard['Id'] ?>">Edit</button>
                    <button class="btn btn-danger" name="delete_guard" value="<?= $guard['Id'] ?>">Delete</button>
                </td>
                </form>
            </tr>
            <?php endforeach; ?>
        </table>


        <h2>Records</h2>
        <form class="add-form" method="post">
            <input type="text" name="itemname" placeholder="Item Name" required>
            <input type="text" name="locationfound" placeholder="Location Found" required>
            <input type="text" name="locationlost" placeholder="Location Lost" required>
            <input type="datetime-local" name="datefound" placeholder="Date Found" required>
            <input type="datetime-local" name="datelost" placeholder="Date Lost" required>
            <input type="text" name="description" placeholder="Description" required>
            <input type="email" name="record_email" placeholder="Email" required>
            <input type="datetime-local" name="dateclaimed" placeholder="Date Claimed" required>
            <input type="text" name="status" placeholder="Status" required>
            <button class="btn btn-success" name="add_record">Add Record</button>
        </form>
        <table>
            <tr>
                <th>Id</th><th>ItemName</th><th>LocationFound</th><th>LocationLost</th><th>DateFound</th><th>DateLost</th><th>Description</th><th>Email</th><th>DateClaimed</th><th>Status</th><th>CreatedAt</th><th>UpdatedAt</th><th>Actions</th>
            </tr>
            <?php foreach ($records as $record): ?>
            <tr>
                <form class="inline" method="post">
                <td><?= $record['Id'] ?></td>
                <td><input type="text" name="edit_itemname" value="<?= htmlspecialchars($record['ItemName']) ?>" required></td>
                <td><input type="text" name="edit_locationfound" value="<?= htmlspecialchars($record['LocationFound']) ?>" required></td>
                <td><input type="text" name="edit_locationlost" value="<?= htmlspecialchars($record['LocationLost']) ?>" required></td>
                <td><input type="datetime-local" name="edit_datefound" value="<?= date('Y-m-d\TH:i', strtotime($record['DateFound'])) ?>" required></td>
                <td><input type="datetime-local" name="edit_datelost" value="<?= date('Y-m-d\TH:i', strtotime($record['DateLost'])) ?>" required></td>
                <td><input type="text" name="edit_description" value="<?= htmlspecialchars($record['Description']) ?>" required></td>
                <td><input type="email" name="edit_record_email" value="<?= htmlspecialchars($record['Email']) ?>" required></td>
                <td><input type="datetime-local" name="edit_dateclaimed" value="<?= date('Y-m-d\TH:i', strtotime($record['DateClaimed'])) ?>" required></td>
                <td><input type="text" name="edit_status" value="<?= htmlspecialchars($record['Status']) ?>" required></td>
                <td><?= $record['CreatedAt'] ?></td>
                <td><?= $record['UpdatedAt'] ?></td>
                <td class="actions">
                    <button class="btn btn-info" name="edit_record" value="<?= $record['Id'] ?>">Edit</button>
                    <button class="btn btn-danger" name="delete_record" value="<?= $record['Id'] ?>">Delete</button>
                </td>
                </form>
            </tr>
            <?php endforeach; ?>
        </table>


        <h2>Lost Items</h2>
        <form class="add-form" method="post">
            <input type="text" name="lost_itemname" placeholder="Item Name" required>
            <input type="text" name="lost_category" placeholder="Category" required>
            <input type="text" name="lost_description" placeholder="Description" required>
            <input type="text" name="lost_locationlost" placeholder="Location Lost" required>
            <input type="datetime-local" name="lost_datelost" placeholder="Date Lost" required>
            <input type="text" name="lost_itemimage" placeholder="Image Path">
            <input type="email" name="lost_email" placeholder="Email" required>
            <input type="text" name="lost_verification_status" placeholder="Verification Status">
            <input type="text" name="lost_verification_notes" placeholder="Verification Notes">
            <input type="datetime-local" name="lost_date_verified" placeholder="Date Verified">
            <button class="btn btn-success" name="add_lostitem">Add Lost Item</button>
        </form>
        <table>
            <tr>
                <th>Id</th><th>ItemName</th><th>Category</th><th>Description</th><th>LocationLost</th><th>DateLost</th><th>itemImage</th><th>Email</th><th>verification_status</th><th>verification_notes</th><th>date_verified</th><th>Actions</th>
            </tr>
            <?php foreach ($lostitems as $item): ?>
            <tr>
                <form class="inline" method="post">
                <td><?= $item['Id'] ?></td>
                <td><input type="text" name="edit_lost_itemname" value="<?= htmlspecialchars($item['ItemName']) ?>" required></td>
                <td><input type="text" name="edit_lost_category" value="<?= htmlspecialchars($item['Category']) ?>" required></td>
                <td><input type="text" name="edit_lost_description" value="<?= htmlspecialchars($item['Description']) ?>" required></td>
                <td><input type="text" name="edit_lost_locationlost" value="<?= htmlspecialchars($item['LocationLost']) ?>" required></td>
                <td><input type="datetime-local" name="edit_lost_datelost" value="<?= date('Y-m-d\TH:i', strtotime($item['DateLost'])) ?>" required></td>
                <td><input type="text" name="edit_lost_itemimage" value="<?= htmlspecialchars($item['itemImage']) ?>"></td>
                <td><input type="email" name="edit_lost_email" value="<?= htmlspecialchars($item['Email']) ?>" required></td>
                <td><input type="text" name="edit_lost_verification_status" value="<?= htmlspecialchars($item['verification_status']) ?>"></td>
                <td><input type="text" name="edit_lost_verification_notes" value="<?= htmlspecialchars($item['verification_notes']) ?>"></td>
                <td><input type="datetime-local" name="edit_lost_date_verified" value="<?= $item['date_verified'] ? date('Y-m-d\TH:i', strtotime($item['date_verified'])) : '' ?>"></td>
                <td class="actions">
                    <button class="btn btn-info" name="edit_lostitem" value="<?= $item['Id'] ?>">Edit</button>
                    <button class="btn btn-danger" name="delete_lostitem" value="<?= $item['Id'] ?>">Delete</button>
                </td>
                </form>
            </tr>
            <?php endforeach; ?>
        </table>


        <h2>Notifications</h2>
        <table>
            <tr>
                <th>id</th><th>user_email</th><th>message</th><th>is_read</th><th>created_at</th><th>Actions</th>
            </tr>
            <?php foreach ($notifications as $note): ?>
            <tr>
                <form class="inline" method="post">
                <td><?= $note['id'] ?></td>
                <td><input type="email" name="edit_user_email" value="<?= htmlspecialchars($note['user_email']) ?>" required></td>
                <td><input type="text" name="edit_message" value="<?= htmlspecialchars($note['message']) ?>" required></td>
                <td><input type="number" name="edit_is_read" value="<?= $note['is_read'] ?>" min="0" max="1" required></td>
                <td><input type="datetime-local" name="edit_created_at" value="<?= date('Y-m-d\TH:i', strtotime($note['created_at'])) ?>" required></td>
                <td class="actions">
                    <button class="btn btn-info" name="edit_notification" value="<?= $note['id'] ?>">Edit</button>
                    <button class="btn btn-danger" name="delete_notification" value="<?= $note['id'] ?>">Delete</button>
                </td>
                </form>
            </tr>
            <?php endforeach; ?>
        </table>

        <div class="report">
            <h2>Quick Reports</h2>
            <ul>
                <li>Total Students: <b><?= count($students) ?></b></li>
                <li>Total Security Guards: <b><?= count($guards) ?></b></li>
                <li>Total Records: <b><?= count($records) ?></b></li>
                <li>Total Lost Items: <b><?= count($lostitems) ?></b></li>
                <li>Total Notifications: <b><?= count($notifications) ?></b></li>
            </ul>
        </div>
    </div>
</body>
</html>
