<?php
include 'config/database.php';
session_start();

if (!isset($_SESSION['cart']) || count($_SESSION['cart']) === 0) {
    header("Location: cart.php");
    exit();
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }

    $user_id = $_SESSION['user_id'];
    $total_price = 0;
    foreach ($_SESSION['cart'] as $item) {
        $total_price += $item['price'] * $item['quantity'];
    }

    // Server-side Validation
    $payment_method = $_POST['payment_method'] ?? 'cod';
    $shipping_address = $_POST['shipping_address'] ?? '';

    if (empty($shipping_address)) {
        $error = "Shipping Address is required.";
    } elseif ($payment_method === 'card') {
        if (empty($_POST['card_number']) || empty($_POST['card_expiry']) || empty($_POST['card_cvv']) || empty($_POST['card_name'])) {
            $error = "All card details are required.";
        }
    } elseif ($payment_method === 'paypal') {
        if (empty($_POST['paypal_email'])) {
            $error = "PayPal email is required.";
        }
    }

    if ($error) {
        // Do nothing, show error below
    } else {
        // Begin Transaction
    $conn->begin_transaction();

    try {
        // Insert Order
        $sql = "INSERT INTO orders (user_id, total_price, status) VALUES ($user_id, $total_price, 'Pending')";
        if (!$conn->query($sql)) {
            throw new Exception("Order creation failed: " . $conn->error);
        }
        $order_id = $conn->insert_id;

        // Insert Order Items
        $insertItemSql = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
        
        foreach ($_SESSION['cart'] as $item) {
            $insertItemSql->bind_param("iiid", $order_id, $item['id'], $item['quantity'], $item['price']);
            if (!$insertItemSql->execute()) {
                throw new Exception("Order item creation failed: " . $insertItemSql->error);
            }
        }

        // Commit
        $conn->commit();
        
        // Clear Cart
        unset($_SESSION['cart']);
        $success = "Order placed successfully! Order ID: #$order_id";
        
    } catch (Exception $e) {
        $conn->rollback();
        $error = "Error placing order: " . $e->getMessage();
    }
    }
}

$pageTitle = 'Checkout';
include 'includes/header.php';

$total = 0;
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $total += $item['price'] * $item['quantity'];
    }
}
?>

<div class="container py-5 my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <?php if ($success): ?>
                <div class="alert alert-success text-center py-5">
                    <i class="bi bi-check-circle display-1 text-success mb-3"></i>
                    <h2>Thank You!</h2>
                    <p class="lead"><?php echo $success; ?></p>
                    <a href="/ShoeZilla/index.php" class="btn btn-primary mt-3">Back to Home</a>
                </div>
            <?php else: ?>
                <h2 class="mb-4">Checkout</h2>
                <?php if ($error): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-header bg-white fw-bold">Order Summary</div>
                            <div class="card-body">
                                <ul class="list-group list-group-flush mb-3">
                                    <?php foreach ($_SESSION['cart'] as $item): ?>
                                        <li class="list-group-item d-flex justify-content-between lh-sm">
                                            <div>
                                                <h6 class="my-0"><?php echo htmlspecialchars($item['name']); ?></h6>
                                                <small class="text-muted">Qty: <?php echo $item['quantity']; ?></small>
                                            </div>
                                            <span class="text-muted">$<?php echo number_format($item['price'] * $item['quantity'], 2); ?></span>
                                        </li>
                                    <?php endforeach; ?>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>Total (USD)</span>
                                        <strong>$<?php echo number_format($total, 2); ?></strong>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-white fw-bold">Payment & Shipping</div>
                            <div class="card-body">
                                <?php if (!isset($_SESSION['user_id'])): ?>
                                    <div class="alert alert-warning">
                                        You must safely <a href="login.php" class="alert-link">login</a> to place an order.
                                    </div>
                                <?php else: ?>
                                    <form method="POST" id="checkoutForm">
                                        <div class="mb-3">
                                            <label class="form-label">Name</label>
                                            <input type="text" class="form-control" value="<?php echo htmlspecialchars($_SESSION['username']); ?>" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Shipping Address</label>
                                            <textarea class="form-control" name="shipping_address" rows="3" required></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Payment Method</label>
                                            <select class="form-select" name="payment_method" id="paymentMethod" onchange="togglePaymentFields()">
                                                <option value="card">Credit or Debit Card</option>
                                                <option value="paypal">PayPal</option>
                                                <option value="cod">Cash on Delivery</option>
                                            </select>
                                        </div>

                                        <!-- Credit Card Fields -->
                                        <div id="cardFields" class="mb-3 p-3 bg-light rounded">
                                            <div class="mb-3">
                                                <label class="form-label small text-muted">Card Number</label>
                                                <input type="text" class="form-control" name="card_number" id="cardNumber" placeholder="0000 0000 0000 0000" required>
                                            </div>
                                            <div class="row">
                                                <div class="col-6 mb-3">
                                                    <label class="form-label small text-muted">Expiry Date</label>
                                                    <input type="text" class="form-control" name="card_expiry" id="cardExpiry" placeholder="MM/YY" required>
                                                </div>
                                                <div class="col-6 mb-3">
                                                    <label class="form-label small text-muted">CVV</label>
                                                    <input type="text" class="form-control" name="card_cvv" id="cardCvv" placeholder="123" required>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label small text-muted">Cardholder Name</label>
                                                <input type="text" class="form-control" name="card_name" id="cardName" placeholder="John Doe" required>
                                            </div>
                                        </div>

                                        <!-- PayPal Fields -->
                                        <div id="paypalFields" class="mb-3 p-3 bg-light rounded d-none">
                                            <div class="mb-3">
                                                <label class="form-label small text-muted">PayPal Email</label>
                                                <input type="email" class="form-control" name="paypal_email" id="paypalEmail" placeholder="you@example.com">
                                            </div>
                                            <div class="alert alert-info small">
                                                <i class="bi bi-info-circle me-1"></i> You will be redirected to PayPal to complete your purchase securely.
                                            </div>
                                        </div>

                                        <script>
                                            function togglePaymentFields() {
                                                const method = document.getElementById('paymentMethod').value;
                                                const cardFields = document.getElementById('cardFields');
                                                const paypalFields = document.getElementById('paypalFields');
                                                
                                                // Inputs
                                                const cardInputs = cardFields.querySelectorAll('input');
                                                const paypalInput = document.getElementById('paypalEmail');

                                                if (method === 'card') {
                                                    cardFields.classList.remove('d-none');
                                                    paypalFields.classList.add('d-none');
                                                    cardInputs.forEach(input => input.setAttribute('required', ''));
                                                    paypalInput.removeAttribute('required');
                                                } else if (method === 'paypal') {
                                                    cardFields.classList.add('d-none');
                                                    paypalFields.classList.remove('d-none');
                                                    cardInputs.forEach(input => input.removeAttribute('required'));
                                                    paypalInput.setAttribute('required', '');
                                                } else {
                                                    cardFields.classList.add('d-none');
                                                    paypalFields.classList.add('d-none');
                                                    cardInputs.forEach(input => input.removeAttribute('required'));
                                                    paypalInput.removeAttribute('required');
                                                }
                                            }
                                            // Run on load to set initial state
                                            window.onload = togglePaymentFields;
                                        </script>
                                        <button type="submit" class="btn btn-success w-100 btn-lg">Place Order</button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
