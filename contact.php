<?php
include 'config/database.php';
session_start();

$message_sent = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    $sql = "INSERT INTO contact_messages (name, email, subject, message) VALUES (
        '" . $conn->real_escape_string($name) . "',
        '" . $conn->real_escape_string($email) . "',
        '" . $conn->real_escape_string($subject) . "',
        '" . $conn->real_escape_string($message) . "'
    )";

    if ($conn->query($sql)) {
        $message_sent = true;
    }
}

$pageTitle = 'Contact Us';
include 'includes/header.php';
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="text-center mb-5">
                <h1 class="display-4 fw-bold mb-3">Get in Touch</h1>
                <p class="lead text-muted">Have questions? We'd love to hear from you.</p>
            </div>

            <?php if ($message_sent): ?>
                <div class="alert alert-success text-center mb-5 p-4 rounded-3 shadow-sm">
                    <i class="bi bi-check-circle-fill display-4 text-success mb-3 d-block"></i>
                    <h4 class="alert-heading">Message Sent!</h4>
                    <p class="mb-0">Thank you for contacting us. We will get back to you shortly.</p>
                </div>
            <?php else: ?>
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-5">
                        <form method="POST">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                <div class="col-12">
                                    <label for="subject" class="form-label">Subject</label>
                                    <input type="text" class="form-control" id="subject" name="subject" required>
                                </div>
                                <div class="col-12">
                                    <label for="message" class="form-label">Message</label>
                                    <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                                </div>
                                <div class="col-12 text-center mt-4">
                                    <button type="submit" class="btn btn-primary px-5 py-3 rounded-pill fw-bold">Send Message</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
