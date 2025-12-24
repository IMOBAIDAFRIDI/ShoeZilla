<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo isset($pageTitle) ? $pageTitle : 'ShoeZilla Admin'; ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/ShoeZilla/css/site.css" />
</head>
<body>
    <header>
        <!-- Reusing the exact same class structure as the main site for consistency -->
        <nav class="navbar navbar-expand-lg navbar-dark-custom mb-0">
            <div class="container">
                <!-- Brand -->
                <a class="navbar-brand me-5 active-pill-brand" href="/ShoeZilla/admin/index.php">ShoeZilla</a>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target=".navbar-collapse" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="navbar-collapse collapse justify-content-center">
                    <!-- Center: Welcome Message styled like a nav item -->
                    <ul class="navbar-nav mx-auto mb-2 mb-lg-0 align-items-center">
                         <li class="nav-item">
                            <span class="nav-link text-white" style="font-size: 1.2rem; cursor: default;">
                                Welcome Back <?php echo htmlspecialchars($_SESSION['username']); ?>
                            </span>
                         </li>
                    </ul>

                    <!-- Right: Sign Out Button -->
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center gap-3">
                        <li class="nav-item">
                            <a class="btn btn-outline-light rounded-pill px-4" href="/ShoeZilla/logout.php">Sign Out</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <div class="container-fluid p-0">
        <main role="main" class="pb-3">
