<?php
include '../config/database.php';
session_start();

if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    header("Location: /ShoeZilla/admin/login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: orders.php");
    exit();
}

$order_id = intval($_GET['id']);
$pageTitle = 'Order Details #' . $order_id;
include 'header_admin.php';

// Fetch Order Info
$orderQuery = "
    SELECT o.*, u.username, u.email 
    FROM orders o 
    LEFT JOIN users u ON o.user_id = u.id 
    WHERE o.id = $order_id
";
$orderResult = $conn->query($orderQuery);

if ($orderResult->num_rows === 0) {
    echo "<div class='container py-5'><div class='alert alert-danger'>Order not found.</div></div>";
    include '../includes/footer.php';
    exit();
}

$order = $orderResult->fetch_assoc();

// Fetch Order Items
$itemsQuery = "
    SELECT oi.*, p.name as product_name, p.image_url 
    FROM order_items oi 
    JOIN products p ON oi.product_id = p.id 
    WHERE oi.order_id = $order_id
";
$itemsResult = $conn->query($itemsQuery);
?>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Order #<?php echo $order['id']; ?></h1>
        <a href="orders.php" class="btn btn-secondary">Back to Orders</a>
    </div>

    <div class="row g-4">
        <div class="col-md-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">Order Items</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Product</th>
                                    <th class="text-center">Price</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-end pe-4">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($item = $itemsResult->fetch_assoc()): ?>
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center">
                                                <img src="<?php echo htmlspecialchars($item['image_url']); ?>" alt="" style="width: 50px; height: 50px; object-fit: contain;" class="me-3 border rounded px-1">
                                                <div>
                                                    <div class="fw-bold"><?php echo htmlspecialchars($item['product_name']); ?></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">$<?php echo number_format($item['price'], 2); ?></td>
                                        <td class="text-center"><?php echo $item['quantity']; ?></td>
                                        <td class="text-end pe-4 fw-bold">$<?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <td colspan="3" class="text-end fw-bold pt-3">Subtotal:</td>
                                    <td class="text-end pe-4 pt-3 fw-bold">$<?php echo number_format($order['total_price'], 2); ?></td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end fw-bold pb-3 border-0">Total:</td>
                                    <td class="text-end pe-4 pb-3 fw-bold border-0 text-success fs-5">$<?php echo number_format($order['total_price'], 2); ?></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">Customer Details</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-light rounded-circle p-3 me-3">
                            <i class="bi bi-person fs-4"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold"><?php echo htmlspecialchars($order['username'] ?? 'Guest'); ?></h6>
                            <small class="text-muted"><?php echo htmlspecialchars($order['email'] ?? 'No email'); ?></small>
                        </div>
                    </div>
                    <?php if (isset($order['shipping_address'])): ?>
                    <hr>
                    <h6 class="fw-bold mb-2">Shipping Address</h6>
                    <p class="text-muted small mb-0">
                        <?php echo nl2br(htmlspecialchars($order['shipping_address'])); ?>
                    </p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">Order Status</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="orders.php">
                        <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                        <input type="hidden" name="action" value="update_status">
                        
                        <div class="mb-3">
                            <label class="form-label text-muted small">Current Status</label>
                            <select name="status" class="form-select">
                                <option value="Pending" <?php echo $order['status'] === 'Pending' ? 'selected' : ''; ?>>Pending</option>
                                <option value="Confirmed" <?php echo $order['status'] === 'Confirmed' ? 'selected' : ''; ?>>Confirmed</option>
                                <option value="Shipped" <?php echo $order['status'] === 'Shipped' ? 'selected' : ''; ?>>Shipped</option>
                                <option value="Delivered" <?php echo $order['status'] === 'Delivered' ? 'selected' : ''; ?>>Delivered</option>
                                <option value="Cancelled" <?php echo $order['status'] === 'Cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                            </select>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Update Status</button>
                        </div>
                    </form>
                    <div class="mt-3 text-center">
                         <span class="text-muted small">Ordered on: <?php echo date('M d, Y h:i A', strtotime($order['created_at'])); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer_admin_clean.php'; ?>
