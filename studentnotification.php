   <?php

?>

<!-- Add this to the guard interface -->
<div class="dropdown">
    <button class="btn btn-secondary dropdown-toggle" type="button" id="notificationDropdown" data-bs-toggle="dropdown">
        Notifications <?= !empty($notifications) ? '<span class="badge bg-danger">'.count($notifications).'</span>' : '' ?>
    </button>
    <ul class="dropdown-menu dropdown-menu-end">
        <?php if (empty($notifications)): ?>
            <li><a class="dropdown-item" href="#">No new notifications</a></li>
        <?php else: ?>
            <?php foreach ($notifications as $notification): ?>
                <li>
                    <a class="dropdown-item" href="guard_verify.php#item-<?= $notification['item_id'] ?>">
                        <?= htmlspecialchars($notification['message']) ?>: <?= htmlspecialchars($notification['item_name']) ?>
                    </a>
                </li>
            <?php endforeach; ?>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item text-center" href="mark_all_read.php">Mark all as read</a></li>
        <?php endif; ?>
    </ul>
</div>