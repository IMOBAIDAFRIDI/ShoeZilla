<?php
include 'config/database.php';

$category = isset($_GET['category']) ? $_GET['category'] : 'All';
$pageTitle = "ShoeZilla - $category";
include 'includes/header.php';

$sql = "SELECT * FROM products";
if ($category != 'All') {
    $categoryEscaped = $conn->real_escape_string($category);
    $sql .= " WHERE category = '$categoryEscaped'";
}
$result = $conn->query($sql);
?>

<div class="container py-5 my-5">
    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold">Shop <?php echo htmlspecialchars($category); ?></h1>
        <div class="title-underline mx-auto"></div>
    </div>

    <div class="row g-4">
        <?php if ($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <div class="col-md-3 col-sm-6">
                    <a href="product.php?id=<?php echo $row['id']; ?>" class="text-decoration-none text-dark">
                        <div class="card product-card h-100 border-0 shadow-sm">
                            <div class="card-img-wrapper position-relative text-center p-4 bg-white">
                                <img src="<?php echo htmlspecialchars($row['image_url']); ?>" class="card-img-top img-fluid"
                                    alt="<?php echo htmlspecialchars($row['name']); ?>" style="max-height: 200px; object-fit: contain;">
                                <span class="btn btn-sm btn-light position-absolute top-0 end-0 m-2 rounded-circle shadow-sm">
                                    <i class="bi bi-heart"></i>
                                </span>
                            </div>
                            <div class="card-body text-center">
                                <h5 class="card-title text-uppercase fw-bold" style="font-size: 0.9rem;">
                                    <?php echo htmlspecialchars($row['name']); ?>
                                </h5>
                                <div class="mb-2">
                                    <span class="fw-bold text-primary">$<?php echo $row['price']; ?></span>
                                    <?php if ($row['old_price']): ?>
                                        <span class="text-muted text-decoration-line-through small ms-1">$<?php echo $row['old_price']; ?></span>
                                    <?php endif; ?>
                                </div>
                                <button class="btn btn-outline-dark btn-sm rounded-pill px-3">View Details</button>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12 text-center py-5">
                <i class="bi bi-inbox fs-1 text-muted mb-3 d-block"></i>
                <h3 class="text-muted">No products found in this category.</h3>
                <a href="/" class="btn btn-primary mt-3">Go Home</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
