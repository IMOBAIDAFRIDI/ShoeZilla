<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Calculate cart count
$cartCount = 0;
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $cartCount += $item['quantity'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo isset($pageTitle) ? $pageTitle : 'ShoeZilla'; ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/ShoeZilla/css/site.css?v=<?php echo time(); ?>" />
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark-custom mb-0">
            <div class="container-fluid px-5">
                <a class="navbar-brand me-5 active-pill-brand" href="/ShoeZilla/">ShoeZilla</a>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target=".navbar-collapse" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="navbar-collapse collapse justify-content-center">
                    <ul class="navbar-nav mx-auto mb-2 mb-lg-0 align-items-center">
                        <li class="nav-item"><a class="nav-link px-3" href="/ShoeZilla/shop.php?category=Men">MEN</a></li>
                        <li class="nav-item"><a class="nav-link px-3" href="/ShoeZilla/shop.php?category=Women">WOMEN</a></li>
                        <li class="nav-item"><a class="nav-link px-3" href="/ShoeZilla/shop.php?category=Kids">KIDS</a></li>
                        <li class="nav-item"><a class="nav-link px-3" href="/ShoeZilla/shop.php?category=Joggers">JOGGERS</a></li>
                    </ul>

                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center gap-3">
                        <li class="nav-item me-2">
                             <form action="/ShoeZilla/search.php" method="get" class="d-flex">
                                 <div class="input-group input-group-sm">
                                     <input type="text" name="query" class="form-control bg-dark border-secondary text-white" placeholder="Search..." aria-label="Search" style="width: 150px;">
                                     <button class="btn btn-outline-secondary text-white" type="submit"><i class="bi bi-search"></i></button>
                                 </div>
                             </form>
                        </li>
                         <li class="nav-item">
                            <a class="nav-link text-white position-relative" href="/ShoeZilla/cart.php">
                                <i class="bi bi-cart" style="font-size: 1.2rem;"></i>
                                <?php if ($cartCount > 0): ?>
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"><?php echo $cartCount; ?></span>
                                <?php endif; ?>
                            </a>
                        </li>
                        
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <li class="nav-item"><a class="nav-link text-white small" href="/ShoeZilla/logout.php">Logout</a></li>
                        <?php else: ?>
                            <li class="nav-item"><a class="nav-link text-white small" href="/ShoeZilla/login.php">Login</a></li>
                        <?php endif; ?>

                        <?php 
                        // Show Admin link only if NOT logged in OR if Admin
                        // Hide if logged in as simple user
                        if (!isset($_SESSION['user_id']) || (isset($_SESSION['is_admin']) && $_SESSION['is_admin'])): 
                        ?>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="/ShoeZilla/admin/index.php">ADMIN</a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <div class="container-fluid p-0">
        <main role="main">
