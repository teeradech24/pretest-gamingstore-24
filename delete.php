<?php
require_once 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
        $stmt->execute([$id]);
    } catch (PDOException $e) {
        // Handle error (optional)
    }
}

header("Location: index.php");
exit();
?>