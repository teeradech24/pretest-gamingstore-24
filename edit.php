<?php
require_once 'db.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];

// Fetch existing data
try {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$id]);
    $product = $stmt->fetch();

    if (!$product) {
        die("Product not found");
    }
} catch (PDOException $e) {
    die($e->getMessage());
}

// Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $image_url = $_POST['image_url'];

    try {
        $sql = "UPDATE products SET name = ?, category = ?, price = ?, stock = ?, image_url = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$name, $category, $price, $stock, $image_url, $id]);
        header("Location: index.php");
        exit();
    } catch (PDOException $e) {
        $error = $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขสินค้า - G-STORE</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>
    <nav class="navbar">
        <div class="brand">
            <i class="fas fa-gamepad"></i> G-STORE
        </div>
        <div class="nav-links">
            <a href="index.php">ย้อนกลับ</a>
        </div>
    </nav>

    <div class="container fade-in">
        <div class="page-header" style="justify-content: center;">
            <h1 class="page-title">แก้ไขข้อมูลสินค้า</h1>
        </div>

        <div class="form-container">
            <?php if (isset($error)): ?>
                <div
                    style="background: rgba(239, 68, 68, 0.1); color: #ef4444; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                <div class="form-group">
                    <label class="form-label">ชื่อสินค้า</label>
                    <input type="text" name="name" class="form-control" required
                        value="<?php echo htmlspecialchars($product['name']); ?>">
                </div>

                <div class="form-group">
                    <label class="form-label">หมวดหมู่</label>
                    <select name="category" class="form-control" required>
                        <?php
                        $categories = ['Mouse', 'Keyboard', 'Headset', 'Monitor', 'Accessory'];
                        foreach ($categories as $cat) {
                            $selected = ($product['category'] === $cat) ? 'selected' : '';
                            echo "<option value='$cat' $selected>$cat</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div>
                        <label class="form-label">ราคา (THB)</label>
                        <input type="number" step="0.01" name="price" class="form-control" required
                            value="<?php echo htmlspecialchars($product['price']); ?>">
                    </div>
                    <div>
                        <label class="form-label">จำนวนสต็อก</label>
                        <input type="number" name="stock" class="form-control" required
                            value="<?php echo htmlspecialchars($product['stock']); ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">URL รูปภาพ</label>
                    <input type="url" name="image_url" class="form-control"
                        value="<?php echo htmlspecialchars($product['image_url']); ?>">
                </div>

                <div style="margin-top: 2rem;">
                    <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center;">
                        <i class="fas fa-save"></i> บันทึกการแก้ไข
                    </button>
                    <a href="index.php" class="btn btn-outline"
                        style="width: 100%; justify-content: center; margin-top: 1rem; border: none;">
                        ยกเลิก
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>