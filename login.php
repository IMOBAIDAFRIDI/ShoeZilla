<?php
include 'config/database.php';
session_start();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = '" . $conn->real_escape_string($email) . "'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Simple password check for seed user '123' without hash, normally use password_verify
        if ($password === $user['password'] || password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['is_admin'] = $user['is_admin'];
            
            
            if ($user['is_admin']) {
                $error = 'Admins must use the <a href="/ShoeZilla/admin/login.php">Admin Login</a> page.';
            } else {
                header("Location: /ShoeZilla/");
                exit();
            }
        } else {
            $error = 'Invalid password.';
        }
    } else {
        $error = 'User not found.';
    }
}

$pageTitle = 'Login';
include 'includes/header.php';
?>

<div class="container py-5 my-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card border-0 shadow-lg">
                <div class="card-body p-5">
                    <h2 class="text-center mb-4 fw-bold">Welcome Back</h2>
                    
                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>

                    <form method="POST">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">Login</button>
                        </div>
                    </form>

                    <div class="text-center my-3">
                        <span class="text-muted small">OR</span>
                    </div>

                    <div class="d-grid gap-2">
                        <a href="https://accounts.google.com/signin" target="_blank" class="btn btn-outline-danger">
                            <i class="bi bi-google me-2"></i> Login with Google
                        </a>
                        <a href="https://www.facebook.com/login" target="_blank" class="btn btn-outline-primary">
                            <i class="bi bi-facebook me-2"></i> Login with Facebook
                        </a>
                    </div>
                    
                    <div class="text-center mt-4">
                        <p class="text-muted">Don't have an account? <a href="register.php" class="text-decoration-none">Sign Up</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
