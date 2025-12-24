<?php
include 'config/database.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$sql = "SELECT * FROM products WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    header("Location: /");
    exit();
}

$product = $result->fetch_assoc();
$pageTitle = $product['name'];
include 'includes/header.php';
?>

<div class="container py-5 my-5">
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm">
                <img src="<?php echo htmlspecialchars($product['image_url']); ?>" class="card-img-top img-fluid" alt="<?php echo htmlspecialchars($product['name']); ?>" style="object-fit: contain; max-height: 500px;">
            </div>
        </div>
        <div class="col-md-6">
            <h1 class="display-5 fw-bold mb-3"><?php echo htmlspecialchars($product['name']); ?></h1>
            <div class="mb-3">
                <span class="badge bg-secondary me-2"><?php echo htmlspecialchars($product['category']); ?></span>
                <?php if ($product['is_featured']): ?>
                    <span class="badge bg-warning text-dark">Featured</span>
                <?php endif; ?>
            </div>
            <div class="mb-4">
                <h2 class="text-primary d-inline me-3">
                    $<?php echo $product['price']; ?>
                </h2>
                <?php if($product['old_price']): ?>
                    <h4 class="text-muted text-decoration-line-through d-inline">
                        $<?php echo $product['old_price']; ?>
                    </h4>
                <?php endif; ?>
            </div>
            
            <p class="lead mb-4"><?php echo htmlspecialchars($product['description']); ?></p>
            
            <div class="d-grid gap-2 d-md-block">
                <?php if($product['stock'] > 0): ?>
                    <form action="cart.php" method="POST" class="row g-3">
                        <input type="hidden" name="action" value="add">
                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                        <input type="hidden" name="name" value="<?php echo htmlspecialchars($product['name']); ?>">
                        <input type="hidden" name="price" value="<?php echo $product['price']; ?>">
                        <input type="hidden" name="image" value="<?php echo htmlspecialchars($product['image_url']); ?>">
                        
                        <div class="col-auto">
                            <label for="quantity" class="visually-hidden">Quantity</label>
                            <input type="number" name="quantity" id="quantity" value="1" min="1" max="<?php echo $product['stock']; ?>" class="form-control" style="width: 80px;">
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-cart-plus me-2"></i>Add to Cart
                            </button>
                        </div>
                    </form>
                <?php else: ?>
                    <div class="alert alert-danger d-inline-block">
                        <i class="bi bi-x-circle me-2"></i>Out of Stock
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
