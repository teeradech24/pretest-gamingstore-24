<?php
require_once 'db.php';

try {
    // Create products table if it doesn't exist
    $sql = "CREATE TABLE IF NOT EXISTS products (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        category VARCHAR(100) NOT NULL,
        price DECIMAL(10, 2) NOT NULL,
        stock INT NOT NULL DEFAULT 0,
        image_url VARCHAR(255),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

    $pdo->exec($sql);

    // Check if empty, add sample data
    $stmt = $pdo->query("SELECT COUNT(*) FROM products");
    if ($stmt->fetchColumn() == 0) {
        $sample_sql = "INSERT INTO products (name, category, price, stock, image_url) VALUES 
            ('Pro Gaming Mouse X1', 'Mouse', 1590.00, 50, 'https://images.unsplash.com/photo-1527814050087-3793815479db?auto=format&fit=crop&w=500&q=80'),
            ('Mechanical Keyboard RGB', 'Keyboard', 2990.00, 30, 'https://images.unsplash.com/photo-1511467687858-23d96c32e4ae?auto=format&fit=crop&w=500&q=80'),
            ('7.1 Surround Headset', 'Headset', 1290.00, 25, 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=500&q=80');";
        $pdo->exec($sample_sql);
        echo "Database initialized with sample data.";
    } else {
        echo "Database already initialized.";
    }

} catch (PDOException $e) {
    echo "Error initializing database: " . $e->getMessage();
}
?>