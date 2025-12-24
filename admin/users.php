<?php
include '../config/database.php';
session_start();

if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    header("Location: /ShoeZilla/admin/login.php");
    exit();
}

$pageTitle = 'Manage Users';
include 'header_admin.php';

// Handle User Deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $delete_id = intval($_POST['delete_id']);
    
    // Check if user is trying to delete the super admin
    $target_user_query = $conn->query("SELECT email FROM users WHERE id = $delete_id");
    $target_user = $target_user_query->fetch_assoc();

    // Prevent deleting self OR the specific super admin email
    if ($delete_id != $_SESSION['user_id'] && $target_user['email'] !== 'admin@shoezilla.com') {
        $conn->query("DELETE FROM users WHERE id = $delete_id");
    }
    header("Location: users.php");
    exit();
}

$admins = $conn->query("SELECT * FROM users WHERE is_admin = 1 ORDER BY created_at DESC");
$customers = $conn->query("SELECT * FROM users WHERE is_admin = 0 ORDER BY created_at DESC");
?>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Manage Users</h1>
        <a href="index.php" class="btn btn-secondary">Back to Dashboard</a>
    </div>

    <?php if (isset($_GET['msg']) && $_GET['msg'] === 'team_added'): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            New Team Member added successfully!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Team Members Section -->
    <div class="card shadow-sm mb-5">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold text-primary"><i class="bi bi-shield-lock me-2"></i>Team Members (Admins)</h5>
            <a href="team_form.php" class="btn btn-sm btn-primary"><i class="bi bi-person-plus-fill me-1"></i> Add Team Member</a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Username</th>
                            <th>Email</th>
                            <th>Joined</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($admin = $admins->fetch_assoc()): ?>
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary-subtle rounded-circle p-2 me-2 text-primary">
                                            <i class="bi bi-person-badge-fill"></i>
                                        </div>
                                        <span class="fw-bold"><?php echo htmlspecialchars($admin['username']); ?></span>
                                        <?php if ($admin['id'] == $_SESSION['user_id']): ?>
                                            <span class="badge bg-success ms-2">You</span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td><?php echo htmlspecialchars($admin['email']); ?></td>
                                <td><?php echo date('M d, Y', strtotime($admin['created_at'])); ?></td>
                                <td>
                                    <?php if ($admin['id'] != $_SESSION['user_id'] && $admin['email'] !== 'admin@shoezilla.com'): ?>
                                        <form method="POST" onsubmit="return confirm('Remove this admin from the team?');" class="d-inline">
                                            <input type="hidden" name="delete_id" value="<?php echo $admin['id']; ?>">
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Remove</button>
                                        </form>
                                    <?php elseif ($admin['email'] === 'admin@shoezilla.com'): ?>
                                        <button class="btn btn-sm btn-secondary" disabled title="Super Admin cannot be removed">Fixed</button>
                                    <?php else: ?>
                                        <button class="btn btn-sm btn-secondary" disabled>Current</button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Customers Section -->
    <div class="card shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold"><i class="bi bi-people me-2"></i>Registered Customers</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">ID</th>
                            <th>Customer</th>
                            <th>Email</th>
                            <th>Joined</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($customers->num_rows > 0): ?>
                            <?php while($user = $customers->fetch_assoc()): ?>
                                <tr>
                                    <td class="ps-4">#<?php echo $user['id']; ?></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-light rounded-circle p-2 me-2">
                                                <i class="bi bi-person"></i>
                                            </div>
                                            <?php echo htmlspecialchars($user['username']); ?>
                                        </div>
                                    </td>
                                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                                    <td><?php echo date('M d, Y', strtotime($user['created_at'])); ?></td>
                                    <td>
                                        <form method="POST" onsubmit="return confirm('Delete this customer account? This cannot be undone.');">
                                            <input type="hidden" name="delete_id" value="<?php echo $user['id']; ?>">
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">No registered customers yet.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include 'footer_admin_clean.php'; ?>
