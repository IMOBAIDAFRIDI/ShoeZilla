<?php
include '../config/database.php';
session_start();

if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    header("Location: /ShoeZilla/admin/login.php");
    exit();
}

$pageTitle = 'Manage Products';
include 'header_admin.php';

// Handle Create/Update/Delete
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_id'])) {
        $id = (int)$_POST['delete_id'];
        $conn->query("DELETE FROM products WHERE id = $id");
        header("Location: products.php");
        exit();
    }
    
    // Add/Edit Logic would go here
    // For brevity, skipping full implementation of Add/Edit form submission in this step, focusing on List and Delete.
}

$products = $conn->query("SELECT * FROM products ORDER BY id DESC");
?>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Manage Products</h1>
        <div>
            <a href="product_form.php" class="btn btn-primary me-2"><i class="bi bi-plus-lg"></i> Add Product</a>
            <a href="index.php" class="btn btn-secondary">Back to Dashboard</a>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Category</th>
                            <th>Stock</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($product = $products->fetch_assoc()): ?>
                            <tr>
                                <td>
                                    <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="" style="width: 50px; height: 50px; object-fit: contain;">
                                </td>
                                <td><?php echo htmlspecialchars($product['name']); ?></td>
                                <td>$<?php echo $product['price']; ?></td>
                                <td><?php echo htmlspecialchars($product['category']); ?></td>
                                <td><?php echo $product['stock']; ?></td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="product_form.php?id=<?php echo $product['id']; ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                        <form method="POST" onsubmit="return confirm('Are you sure?');">
                                            <input type="hidden" name="delete_id" value="<?php echo $product['id']; ?>">
                                            <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include 'footer_admin_clean.php'; ?>
