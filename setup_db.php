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
            ('ASUS ROG Strix G16', 'Laptop', 45900.00, 10, 'https://images.unsplash.com/photo-1603302576837-37561b2e2302?auto=format&fit=crop&w=500&q=80'),
            ('Intel Core i9-13900K', 'CPU', 22500.00, 15, 'https://images.unsplash.com/photo-1591799264318-7e6ef8ddb7ea?auto=format&fit=crop&w=500&q=80'),
            ('NVIDIA RTX 4080 Super', 'GPU', 42900.00, 5, 'https://images.unsplash.com/photo-1591488320449-011701bb6704?auto=format&fit=crop&w=500&q=80'),
            ('Samsung Odyssey G7 28\"', 'Monitor', 18900.00, 8, 'https://images.unsplash.com/photo-1527443224154-c4a3942d3acf?auto=format&fit=crop&w=500&q=80'),
            ('Logitech G Pro X Superlight', 'Peripheral', 4590.00, 25, 'https://images.unsplash.com/photo-1527814050087-3793815479db?auto=format&fit=crop&w=500&q=80');";
        $pdo->exec($sample_sql);
        echo "Database initialized with computer store sample data.";
    } else {
        echo "Database already initialized.";
    }

} catch (PDOException $e) {
    echo "Error initializing database: " . $e->getMessage();
}
?>