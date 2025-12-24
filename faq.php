<?php
session_start();
$pageTitle = 'FAQ';
include 'includes/header.php';
?>

<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="fw-bold">Frequently Asked Questions</h1>
        <p class="text-muted">Find answers to common questions about our products and services.</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="accordion" id="faqAccordion">
                
                <!-- Shipping -->
                <div class="accordion-item mb-3 border rounded shadow-sm">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            How long does shipping take?
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                        <div class="accordion-body text-muted">
                            Standard shipping typically takes 3-5 business days. Express shipping options are available at checkout and usually arrive within 1-2 business days.
                        </div>
                    </div>
                </div>

                <!-- Returns -->
                <div class="accordion-item mb-3 border rounded shadow-sm">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            What is your return policy?
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                        <div class="accordion-body text-muted">
                            We offer a 30-day return policy for all unworn items in their original packaging. Please visit our <a href="returns.php">Returns & Exchanges</a> page for more details.
                        </div>
                    </div>
                </div>

                <!-- Tracking -->
                <div class="accordion-item mb-3 border rounded shadow-sm">
                    <h2 class="accordion-header" id="headingThree">
                        <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            How can I track my order?
                        </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                        <div class="accordion-body text-muted">
                            Once your order has shipped, you will receive an email with a tracking number. You can also use our <a href="tracking.php">Order Status</a> page to check the current status of your shipment.
                        </div>
                    </div>
                </div>

                <!-- Payment -->
                <div class="accordion-item mb-3 border rounded shadow-sm">
                    <h2 class="accordion-header" id="headingFour">
                        <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                            What payment methods do you accept?
                        </button>
                    </h2>
                    <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#faqAccordion">
                        <div class="accordion-body text-muted">
                            We accept all major credit cards (Visa, MasterCard, American Express), PayPal, and Apple Pay.
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
