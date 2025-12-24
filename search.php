<?php
include 'config/database.php';

$query = isset($_GET['query']) ? $_GET['query'] : '';
$pageTitle = "Search Results for '$query'";
include 'includes/header.php';

$sql = "SELECT * FROM products WHERE name LIKE '%" . $conn->real_escape_string($query) . "%'";
$result = $conn->query($sql);
?>

<div class="container py-5 my-5">
    <div class="text-center mb-5">
        <h1 class="display-5 fw-bold">Search Results</h1>
        <p class="text-muted">Showing results for "<?php echo htmlspecialchars($query); ?>"</p>
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
                            </div>
                            <div class="card-body text-center">
                                <h5 class="card-title text-uppercase fw-bold" style="font-size: 0.9rem;">
                                    <?php echo htmlspecialchars($row['name']); ?>
                                </h5>
                                <p class="card-text fw-bold text-primary">$<?php echo $row['price']; ?></p>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12 text-center py-5">
                <i class="bi bi-search fs-1 text-muted mb-3 d-block"></i>
                <h3 class="text-muted">No results found for "<?php echo htmlspecialchars($query); ?>"</h3>
                <p>Try searching for something else.</p>
                <a href="/" class="btn btn-primary mt-3">Back to Store</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
