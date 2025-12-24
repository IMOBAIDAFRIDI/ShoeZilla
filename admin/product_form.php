<?php
include '../config/database.php';
session_start();

if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    header("Location: /ShoeZilla/admin/login.php");
    exit();
}

$pageTitle = 'Manage Product';
include 'header_admin.php';

$product = [
    'id' => '',
    'name' => '',
    'description' => '',
    'price' => '',
    'category' => 'Men',
    'stock' => '',
    'image_url' => ''
];

$is_editing = false;
$error = '';
$success = '';

// Check if editing
if (isset($_GET['id'])) {
    $is_editing = true;
    $id = intval($_GET['id']);
    $result = $conn->query("SELECT * FROM products WHERE id = $id");
    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    } else {
        header("Location: products.php");
        exit();
    }
}

// Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $description = $conn->real_escape_string($_POST['description']);
    $price = floatval($_POST['price']);
    $category = $conn->real_escape_string($_POST['category']);
    $stock = intval($_POST['stock']);
    $image_url = $conn->real_escape_string($_POST['image_url']);

    if ($is_editing) {
        $id = intval($_POST['id']);
        $sql = "UPDATE products SET 
                name='$name', 
                description='$description', 
                price=$price, 
                category='$category', 
                stock=$stock, 
                image_url='$image_url' 
                WHERE id=$id";
    } else {
        $sql = "INSERT INTO products (name, description, price, category, stock, image_url) 
                VALUES ('$name', '$description', $price, '$category', $stock, '$image_url')";
    }

    if ($conn->query($sql)) {
        header("Location: products.php");
        exit();
    } else {
        $error = "Database Error: " . $conn->error;
    }
}
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h4 class="mb-0 fw-bold"><?php echo $is_editing ? 'Edit Product' : 'Add New Product'; ?></h4>
                </div>
                <div class="card-body p-4">
                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>

                    <form method="POST">
                        <?php if ($is_editing): ?>
                            <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                        <?php endif; ?>

                        <div class="mb-3">
                            <label class="form-label">Product Name</label>
                            <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($product['name']); ?>" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Price ($)</label>
                                <input type="number" step="0.01" name="price" class="form-control" value="<?php echo $product['price']; ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Stock Quantity</label>
                                <input type="number" name="stock" class="form-control" value="<?php echo $product['stock']; ?>" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <select name="category" class="form-select" required>
                                <option value="Men" <?php echo $product['category'] === 'Men' ? 'selected' : ''; ?>>Men</option>
                                <option value="Women" <?php echo $product['category'] === 'Women' ? 'selected' : ''; ?>>Women</option>
                                <option value="Kids" <?php echo $product['category'] === 'Kids' ? 'selected' : ''; ?>>Kids</option>
                                <option value="Joggers" <?php echo $product['category'] === 'Joggers' ? 'selected' : ''; ?>>Joggers</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Image URL</label>
                            <input type="url" name="image_url" class="form-control" value="<?php echo htmlspecialchars($product['image_url']); ?>" placeholder="https://example.com/image.jpg" required>
                            <?php if ($product['image_url']): ?>
                                <div class="mt-2 text-muted small">Preview: <img src="<?php echo htmlspecialchars($product['image_url']); ?>" height="30" class="ms-2 border rounded"></div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="4"><?php echo htmlspecialchars($product['description']); ?></textarea>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="products.php" class="btn btn-outline-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary px-5"><?php echo $is_editing ? 'Update Product' : 'Add Product'; ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer_admin_clean.php'; ?>
