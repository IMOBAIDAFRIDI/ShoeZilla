<?php
include '../config/database.php';
session_start();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = '" . $conn->real_escape_string($email) . "'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Check if user is admin
        if ($user['is_admin']) {
            // Verify password
            if ($password === $user['password'] || password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['is_admin'] = $user['is_admin'];
                
                header("Location: /ShoeZilla/admin/index.php");
                exit();
            } else {
                $error = 'Invalid credentials.';
            }
        } else {
            // Found user but not admin
            $error = 'Access Denied. This area is for Admins only.';
        }
    } else {
        $error = 'Invalid credentials.';
    }
}

$pageTitle = 'Admin Login';
// We can manually include header parts if we want to avoid the main navbar, 
// but reusing header is consistent. 
// We just need to make sure the "Sign Up" link isn't prominent if we use the main header.
// However, the main header has "Login" link.
// Let's use the main header for valid CSS/JS but maybe hide the navbar content if possible, or just accept it.
// The user said "admin page pe sign up ka option na ho". 
// I will just use the header but ensuring the BODY content has no signup link.
include '../includes/header.php'; 
?>

<div class="container py-5 my-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card border-0 shadow-lg bg-dark text-white">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <i class="bi bi-shield-lock display-4 text-warning"></i>
                        <h2 class="mt-3 fw-bold">Admin Login</h2>
                        <p class="text-white-50">Authorized Personnel Only</p>
                    </div>
                    
                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>

                    <form method="POST">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control bg-secondary text-white border-0" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control bg-secondary text-white border-0" id="password" name="password" required>
                        </div>
                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-warning btn-lg fw-bold text-dark">Access Dashboard</button>
                        </div>
                    </form>
                    
                    <!-- strictly NO signup link here as requested -->
                </div>
            </div>
            <div class="text-center mt-3">
                <a href="/ShoeZilla/index.php" class="text-muted text-decoration-none small"><i class="bi bi-arrow-left"></i> Back to Shop</a>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
