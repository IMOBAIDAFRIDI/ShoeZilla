<?php
session_start();
$pageTitle = 'Returns & Exchanges';
include 'includes/header.php';
?>

<div class="container py-5 my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h1 class="fw-bold mb-4">Returns & Exchanges</h1>
            
            <div class="mb-5">
                <h3 class="fw-bold mb-3">Our Return Policy</h3>
                <p class="text-muted leading-relaxed">
                    At ShoeZilla, we want you to love your purchase. If you are not completely satisfied, you may return any unworn, unwashed item with original tags within <strong>30 days</strong> of delivery for a full refund or exchange.
                </p>
            </div>

            <div class="mb-5">
                <h3 class="fw-bold mb-3">How to Return an Item</h3>
                <ol class="list-group list-group-numbered border-0">
                    <li class="list-group-item border-0 ps-0">Pack the item securely in its original packaging.</li>
                    <li class="list-group-item border-0 ps-0">Include your proof of purchase or order number.</li>
                    <li class="list-group-item border-0 ps-0">Mail your return to the address listed below.</li>
                </ol>
            </div>

            <div class="alert alert-secondary p-4 mb-5">
                <h5 class="fw-bold"><i class="bi bi-geo-alt-fill me-2"></i>Return Address:</h5>
                <p class="mb-0">
                    ShoeZilla Returns Dept.<br>
                    123 Fashion Ave, Suite 500<br>
                    New York, NY 10001<br>
                    USA
                </p>
            </div>

            <div class="mb-5">
                <h3 class="fw-bold mb-3">Exchanges</h3>
                <p class="text-muted">
                    If you need a different size or color, please return your original item for a refund and place a new order. This ensures you get the item you want as quickly as possible.
                </p>
            </div>

            <div class="mb-5">
                <h3 class="fw-bold mb-3">Refunds</h3>
                <p class="text-muted">
                    Refunds will be processed within 5-7 business days of receiving your return. The amount will be credited back to your original payment method.
                </p>
            </div>

            <div class="text-center mt-5">
                <p class="text-muted">Still have questions?</p>
                <a href="contact.php" class="btn btn-outline-dark px-4">Contact Customer Service</a>
            </div>

        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
