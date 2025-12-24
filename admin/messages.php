<?php
include '../config/database.php';
session_start();

if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    header("Location: /ShoeZilla/admin/login.php");
    exit();
}

$pageTitle = 'Customer Messages';
include 'header_admin.php';

// Handle Delete
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $delete_id = intval($_POST['delete_id']);
    $conn->query("DELETE FROM contact_messages WHERE id = $delete_id");
    header("Location: messages.php");
    exit();
}

$messages = $conn->query("SELECT * FROM contact_messages ORDER BY created_at DESC");
?>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Customer Messages</h1>
        <a href="index.php" class="btn btn-secondary">Back to Dashboard</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Date</th>
                            <th>Sender</th>
                            <th>Subject</th>
                            <th style="width: 40%;">Message</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($messages->num_rows > 0): ?>
                            <?php while($msg = $messages->fetch_assoc()): ?>
                                <tr>
                                    <td class="text-nowrap text-secondary small">
                                        <?php echo date('M d, Y', strtotime($msg['created_at'])); ?><br>
                                        <?php echo date('h:i A', strtotime($msg['created_at'])); ?>
                                    </td>
                                    <td>
                                        <div class="fw-bold"><?php echo htmlspecialchars($msg['name']); ?></div>
                                        <div class="small text-muted"><?php echo htmlspecialchars($msg['email']); ?></div>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border">
                                            <?php echo htmlspecialchars($msg['subject'] ?? 'No Subject'); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="text-truncate-3" style="max-height: 100px; overflow-y: auto;">
                                            <?php echo nl2br(htmlspecialchars($msg['message'])); ?>
                                        </div>
                                    </td>
                                    <td>
                                        <form method="POST" onsubmit="return confirm('Delete this message permanently?');">
                                            <input type="hidden" name="delete_id" value="<?php echo $msg['id']; ?>">
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete Message">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-3 opacity-25"></i>
                                    No messages found.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include 'footer_admin_clean.php'; ?>
