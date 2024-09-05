
<?php


require_once 'Database.php';
require_once 'models/Dvd.php';
require_once 'models/Book.php';
require_once 'models/Furniture.php';

try {
    $db = new Database();
    $conn = $db->getConnection();

    $sku = trim($_POST['sku']);
    $name = trim($_POST['name']);
    $price = trim($_POST['price']);
    $productType = trim($_POST['product_type']);

    switch ($productType) {
        case 'dvd':
            $size = trim($_POST['size']);
            $product = new DVD($sku, $name, $price, $size, $conn);
            break;
        case 'book':
            $weight = trim($_POST['weight']);
            $product = new Book($sku, $name, $price, $weight, $conn);
            break;
        case 'furniture':
            $height = trim($_POST['height']);
            $width = trim($_POST['width']);
            $length = trim($_POST['length']);
            $product = new Furniture($sku, $name, $price, $height, $width, $length, $conn);
            break;
        default:
            throw new Exception("Invalid product type.");
    }

    $product->save();
    $db->closeConnection();
    header("Location: index.php?status=added");
    exit();
} catch (Exception $e) {
    $db->closeConnection();
    header("Location: add_product.php?error=" . urlencode($e->getMessage()));
    exit();
}
