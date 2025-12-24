<?php
include 'config/database.php';
session_start();

$order_info = null;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['order_id'])) {
    $order_id = intval($_GET['order_id']);
    if ($order_id > 0) {
        $sql = "SELECT * FROM orders WHERE id = $order_id";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $order_info = $result->fetch_assoc();
        } else {
            $error = 'Order not found. Please check your Order ID.';
        }
    }
}

$pageTitle = 'Order Status';
include 'includes/header.php';
?>

<div class="container py-5 my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="text-center mb-5">
                <i class="bi bi-box-seam display-1 text-primary mb-3"></i>
                <h1 class="fw-bold">Track Your Order</h1>
                <p class="text-muted">Enter your Order ID to check the current status.</p>
            </div>

            <div class="card border-0 shadow-lg mb-4">
                <div class="card-body p-4">
                    <form method="GET" class="d-flex gap-2">
                        <input type="number" name="order_id" class="form-control form-control-lg" placeholder="e.g. 1001" required value="<?php echo isset($_GET['order_id']) ? htmlspecialchars($_GET['order_id']) : ''; ?>">
                        <button type="submit" class="btn btn-primary btn-lg px-4">Track</button>
                    </form>
                </div>
            </div>

            <?php if ($error): ?>
                <div class="alert alert-danger text-center"><?php echo $error; ?></div>
            <?php endif; ?>

            <?php if ($order_info): ?>
                <div class="card border-0 shadow-sm mt-4">
                    <div class="card-header bg-white py-3 border-bottom">
                        <h5 class="mb-0 fw-bold">Order Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-6 text-muted">Order ID:</div>
                            <div class="col-6 fw-bold">#<?php echo $order_info['id']; ?></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6 text-muted">Date:</div>
                            <div class="col-6"><?php echo date('M d, Y', strtotime($order_info['created_at'])); ?></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6 text-muted">Total:</div>
                            <div class="col-6 fw-bold text-success">$<?php echo number_format($order_info['total_price'], 2); ?></div>
                        </div>
                        <hr>
                        <div class="row align-items-center">
                            <div class="col-6 text-muted">Current Status:</div>
                            <div class="col-6">
                                <span class="badge bg-info text-dark fs-6 px-3 py-2"><?php echo htmlspecialchars($order_info['status']); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
