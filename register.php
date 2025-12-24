<?php
include 'config/database.php';
session_start();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if email exists
    $checkSql = "SELECT id FROM users WHERE email = '" . $conn->real_escape_string($email) . "'";
    if ($conn->query($checkSql)->num_rows > 0) {
        $error = 'Email already registered.';
    } else {
        // Hash password
        $hashedInfo = password_hash($password, PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO users (username, email, password) VALUES (
            '" . $conn->real_escape_string($username) . "',
            '" . $conn->real_escape_string($email) . "',
            '$hashedInfo'
        )";

        if ($conn->query($sql)) {
            header("Location: login.php");
            exit();
        } else {
            $error = 'Registration failed. Please try again.';
        }
    }
}

$pageTitle = 'Register';
include 'includes/header.php';
?>

<div class="container py-5 my-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card border-0 shadow-lg">
                <div class="card-body p-5">
                    <h2 class="text-center mb-4 fw-bold">Create Account</h2>
                    
                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>

                    <form method="POST">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">Sign Up</button>
                        </div>
                    </form>

                    <div class="text-center my-3">
                        <span class="text-muted small">OR</span>
                    </div>

                    <div class="d-grid gap-2">
                        <a href="https://accounts.google.com/signin" target="_blank" class="btn btn-outline-danger">
                            <i class="bi bi-google me-2"></i> Continue with Google
                        </a>
                        <a href="https://www.facebook.com/login" target="_blank" class="btn btn-outline-primary">
                            <i class="bi bi-facebook me-2"></i> Continue with Facebook
                        </a>
                    </div>
                    
                    <div class="text-center mt-4">
                        <p class="text-muted">Already have an account? <a href="login.php" class="text-decoration-none">Login</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
