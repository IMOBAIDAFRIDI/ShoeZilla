<?php
$pageTitle = 'ShoeZilla - Home';
include 'config/database.php';
include 'includes/header.php';

// Fetch Featured Products
$sql = "SELECT * FROM products WHERE is_featured = 1 LIMIT 4";
$result = $conn->query($sql);
?>

<div class="hero-wrapper">
    <div class="hero-overlay" style="background: rgba(0,0,0,0.1);"></div>

    <div class="sale-card">
        <h1 class="sale-title">SALE</h1>
        <h2 class="sale-subtitle">SUPER OFFER</h2>
        <p class="sale-text">
            Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt aliquam.
        </p>
        <a href="shop.php?category=Men" class="btn btn-shop-copper">SHOP NOW</a>
    </div>

    <div class="social-sidebar">
        <a href="#" class="social-icon text-decoration-none"><i class="bi bi-facebook"></i></a>
        <a href="#" class="social-icon text-decoration-none"><i class="bi bi-twitter"></i></a>
        <a href="#" class="social-icon text-decoration-none"><i class="bi bi-instagram"></i></a>
    </div>

    <div class="pointer-marker">
        <div class="pointer-dot">
            <div class="pointer-inner"></div>
        </div>
        <div class="pointer-line"></div>
        <div class="pointer-text">NEW SHOES</div>
    </div>

    <div class="slider-dots">
        <div class="dot active"></div>
        <div class="dot"></div>
        <div class="dot"></div>
        <div class="dot"></div>
    </div>
</div>

<div class="container-fluid py-5 bg-light">
    <div class="text-center mb-5">
        <h2 class="section-title">FEATURED ITEMS</h2>
        <div class="title-underline mx-auto"></div>
    </div>

    <div class="container">
        <div class="featured-parent-card p-5">
            <div class="row g-4">
                <?php if ($result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <div class="col-md-3 col-sm-6">
                            <a href="product.php?id=<?php echo $row['id']; ?>" class="text-decoration-none text-dark">
                                <div class="card product-card h-100">
                                    <div class="card-img-wrapper position-relative text-center p-4">
                                        <img src="<?php echo htmlspecialchars($row['image_url']); ?>" class="card-img-top img-fluid" alt="<?php echo htmlspecialchars($row['name']); ?>" style="max-height: 200px; object-fit: contain;">
                                        <span class="btn btn-sm btn-light position-absolute top-0 end-0 m-2 rounded-circle shadow-sm">
                                            <i class="bi bi-heart"></i>
                                        </span>
                                    </div>
                                    <div class="card-body text-center">
                                        <h5 class="card-title text-uppercase fw-bold" style="font-size: 0.9rem;">
                                            <?php echo htmlspecialchars($row['name']); ?>
                                        </h5>
                                        <p class="card-text fw-bold text-muted">$<?php echo $row['price']; ?></p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="col-12 text-center text-muted">No featured items available.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid p-0 m-0">
    <div class="promo-banner position-relative d-flex align-items-center justify-content-end pe-5"
        style="background: url('https://static.nike.com/a/images/f_auto/dpr_1.0,cs_srgb/h_1632,c_limit/tpqid8vgfey6m4ke86te/nike-joyride.jpg') no-repeat center center/cover; height: 600px;">

        <div class="promo-overlay position-absolute top-0 start-0 w-100 h-100"
            style="background: rgba(0,0,0,0.5); pointer-events: none;"></div>

        <div class="promo-content position-absolute z-1 text-white me-5 p-4 top-50 translate-middle-y end-0" style="max-width: 500px;">
            <span class="badge bg-danger mb-3 px-3 py-2">LIMITED TIME OFFER</span>
            <h2 class="display-4 fw-bold mb-2">50% DISCOUNT</h2>
            <h3 class="h2 fw-light mb-4 text-uppercase">ON NIKE JOGGERS</h3>
            <p class="mb-4 text-white-50">
                Experience ultimate comfort and style with our premium collection.
            </p>
            <a href="shop.php?category=Joggers" class="btn btn-shop-copper btn-lg px-5">
                SHOP NOW
            </a>
        </div>
    </div>
</div>


<?php include 'includes/footer.php'; ?>
