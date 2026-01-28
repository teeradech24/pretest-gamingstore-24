<?php
require_once 'db.php';

// Initialize setup if needed (Silent check)
// In prod, check table existence properly, here we just include it if it's the very first run logic
// For now, we assume setup_db.php is run manually or we handle valid SQL errors gracefully.
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gaming Store System</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>
    <nav class="navbar">
        <div class="brand">
            <i class="fas fa-gamepad"></i> G-STORE
        </div>
        <div class="nav-links">
            <a href="index.php" class="active">หน้าแรก</a>
            <a href="setup_db.php" target="_blank">Reset DB</a>
        </div>
    </nav>

    <div class="container fade-in">
        <div class="page-header">
            <div>
                <h1 class="page-title">จัดการสินค้า</h1>
                <p style="color: var(--text-secondary); margin-top: 0.5rem;">ระบบจัดการคลังสินค้าอุปกรณ์เกมมิ่ง</p>
            </div>
            <a href="create.php" class="btn btn-primary">
                <i class="fas fa-plus"></i> เพิ่มสินค้าใหม่
            </a>
        </div>

        <?php
        try {
            $stmt = $pdo->query("SELECT * FROM products ORDER BY created_at DESC");
            $products = $stmt->fetchAll();
        } catch (PDOException $e) {
            // If table doesn't exist, prompt to setup
            if (strpos($e->getMessage(), "doesn't exist") !== false) {
                echo "<div style='text-align:center; padding: 2rem; background: var(--card-bg); border-radius: 12px;'>
                        <h2>ไม่พบฐานข้อมูล</h2>
                        <p style='margin: 1rem 0;'>โปรดคลิกปุ่มด้านล่างเพื่อเริ่มการติดตั้งฐานข้อมูล</p>
                        <a href='setup_db.php' class='btn btn-primary'>ติดตั้งฐานข้อมูล</a>
                      </div>";
                $products = [];
            } else {
                echo "<p>Error: " . $e->getMessage() . "</p>";
                $products = [];
            }
        }
        ?>

        <?php if (!empty($products)): ?>
            <div class="product-grid">
                <?php foreach ($products as $product): ?>
                    <div class="product-card">
                        <img src="<?php echo htmlspecialchars($product['image_url'] ?: 'https://via.placeholder.com/300x200?text=No+Image'); ?>"
                            alt="<?php echo htmlspecialchars($product['name']); ?>" class="card-img">
                        <div class="card-body">
                            <div class="card-category">
                                <?php echo htmlspecialchars($product['category']); ?>
                            </div>
                            <h3 class="card-title">
                                <?php echo htmlspecialchars($product['name']); ?>
                            </h3>
                            <div class="card-price">
                                ฿
                                <?php echo number_format($product['price'], 2); ?>
                                <span class="stock-badge">
                                    <i class="fas fa-box"></i>
                                    <?php echo $product['stock']; ?>
                                </span>
                            </div>
                            <div class="card-actions">
                                <a href="edit.php?id=<?php echo $product['id']; ?>" class="btn btn-outline btn-card">
                                    <i class="fas fa-edit"></i> แก้ไข
                                </a>
                                <a href="delete.php?id=<?php echo $product['id']; ?>" class="btn btn-danger btn-card"
                                    onclick="return confirm('ยืนยันการลบสินค้านี้?');">
                                    <i class="fas fa-trash"></i> ลบ
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php elseif (isset($pdo) && !isset($e)): ?>
            <div style="text-align: center; padding: 4rem; color: var(--text-secondary);">
                <i class="fas fa-ghost" style="font-size: 4rem; opacity: 0.5; margin-bottom: 1rem;"></i>
                <p>ยังไม่มีสินค้าในระบบ</p>
            </div>
        <?php endif; ?>
    </div>
</body>

</html>