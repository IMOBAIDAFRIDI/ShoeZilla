<?php
include '../config/database.php';
session_start();

// Admin Check
if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    header("Location: /ShoeZilla/admin/login.php");
    exit();
}

$pageTitle = 'Admin Dashboard';
// Re-using main header but fixing paths for admin context
// For simplicity, including header content directly or adjusting paths would be better.
// Here we'll just include the main header and trust relative paths for CSS work (since /assets is root relative)
include 'header_admin.php';

// Stats
$productCount = $conn->query("SELECT COUNT(*) as count FROM products")->fetch_assoc()['count'];
$userCount = $conn->query("SELECT COUNT(*) as count FROM users")->fetch_assoc()['count'];
$orderCount = $conn->query("SELECT COUNT(*) as count FROM orders")->fetch_assoc()['count'];
$messageCount = $conn->query("SELECT COUNT(*) as count FROM contact_messages")->fetch_assoc()['count'];
?>

<div class="container py-5">
    <h1 class="mb-4">Admin Dashboard</h1>

    <style>
        .admin-card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            position: relative;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .admin-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }
        .admin-card .card-body {
            position: relative;
            z-index: 2;
            padding: 2rem;
        }
        .admin-card .bg-icon {
            position: absolute;
            right: -20px;
            bottom: -20px;
            font-size: 8rem;
            opacity: 0.15;
            z-index: 1;
            transform: rotate(-15deg);
        }
        .card-gradient-1 { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .card-gradient-2 { background: linear-gradient(135deg, #2af598 0%, #009efd 100%); }
        .card-gradient-3 { background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 99%, #fecfef 100%); background: linear-gradient(135deg, #ff0844 0%, #ffb199 100%); }
        .card-gradient-4 { background: linear-gradient(135deg, #a18cd1 0%, #fbc2eb 100%); }
    </style>

    <div class="row g-4 mb-5">
        <!-- Products Card -->
        <div class="col-md-3">
            <div class="admin-card card-gradient-1 text-white h-100">
                <div class="bg-icon"><i class="bi bi-box-seam"></i></div>
                <div class="card-body d-flex flex-column justify-content-between">
                    <div>
                        <h5 class="text-uppercase opacity-75 fw-bold ls-1">Products</h5>
                        <h2 class="display-4 fw-bold mb-0"><?php echo $productCount; ?></h2>
                    </div>
                    <div class="mt-4">
                        <a href="products.php" class="btn btn-outline-light rounded-pill px-3 stretched-link">Manage</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Orders Card -->
        <div class="col-md-3">
            <div class="admin-card card-gradient-2 text-white h-100">
                <div class="bg-icon"><i class="bi bi-cart-check"></i></div>
                <div class="card-body d-flex flex-column justify-content-between">
                    <div>
                        <h5 class="text-uppercase opacity-75 fw-bold ls-1">Orders</h5>
                        <h2 class="display-4 fw-bold mb-0"><?php echo $orderCount; ?></h2>
                    </div>
                    <div class="mt-4">
                        <a href="orders.php" class="btn btn-outline-light rounded-pill px-3 stretched-link">Manage</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Users Card -->
        <div class="col-md-3">
            <div class="admin-card card-gradient-3 text-white h-100">
                <div class="bg-icon"><i class="bi bi-people"></i></div>
                <div class="card-body d-flex flex-column justify-content-between">
                    <div>
                        <h5 class="text-uppercase opacity-75 fw-bold ls-1">Users</h5>
                        <h2 class="display-4 fw-bold mb-0"><?php echo $userCount; ?></h2>
                    </div>
                    <div class="mt-4">
                        <a href="users.php" class="btn btn-outline-light rounded-pill px-3 stretched-link">View</a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Messages Card -->
        <div class="col-md-3">
            <div class="admin-card card-gradient-4 text-white h-100">
                <div class="bg-icon"><i class="bi bi-envelope"></i></div>
                <div class="card-body d-flex flex-column justify-content-between">
                    <div>
                        <h5 class="text-uppercase opacity-75 fw-bold ls-1">Messages</h5>
                        <h2 class="display-4 fw-bold mb-0"><?php echo $messageCount; ?></h2>
                    </div>
                    <div class="mt-4">
                        <a href="messages.php" class="btn btn-outline-light rounded-pill px-3 stretched-link">Read</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="alert alert-info">
        <h5>Quick Actions</h5>
        <a href="products.php?action=create" class="btn btn-outline-dark me-2">Add New Product</a>
    </div>
</div>

<?php include 'footer_admin_clean.php'; ?>
