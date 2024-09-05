<?php
require_once 'Database.php';
require_once 'services/ProductService.php';

try {
    $database = new Database();
    $productService = new ProductService($database);

    $productIds = isset($_POST['product_ids']) ? $_POST['product_ids'] : [];
    $productService->deleteProducts($productIds);

    // Redirect to the product list page
    header("Location: index.php?status=deleted");
    exit();
} catch (Exception $e) {
    echo $e->getMessage();
    // Handle the error, e.g., log it
} finally {
    if (isset($database)) {
        $database->closeConnection();
    }
}
