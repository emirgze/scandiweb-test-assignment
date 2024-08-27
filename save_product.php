<?php
require_once('config/db/connection.php');


// Database configuration
define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_DATABASE", "scandiweb");

// Establish database connection using MySQLi
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);

// Check connection
if ($mysqli->connect_errno) {
    die("Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
}

// Retrieve and sanitize input
$sku = trim($_POST['sku']);
$name = trim($_POST['name']);
$price = trim($_POST['price']);
$productType = trim($_POST['product_type']);

// Basic validation
if (empty($sku) || empty($name) || empty($price) || empty($productType)) {
    header("Location: add_product.php?error=invalid_input");
    exit();
}

// Check for existing SKU using prepared statement
$stmt = $mysqli->prepare("SELECT id FROM products WHERE sku = ?");
$stmt->bind_param("s", $sku);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->close();
    $mysqli->close();
    header("Location: add_product.php?error=sku_exists");
    exit();
}
$stmt->close();

// Prepare insert statement based on product type
switch ($productType) {
    case 'dvd':
        $size = trim($_POST['size']);
        if (empty($size) || !is_numeric($size) || $size <= 0) {
            header("Location: add_product.php?error=invalid_input");
            exit();
        }
        $stmt = $mysqli->prepare("INSERT INTO products (sku, name, price, product_type, size) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdsi", $sku, $name, $price, $productType, $size);
        break;

    case 'book':
        $weight = trim($_POST['weight']);
        if (empty($weight) || !is_numeric($weight) || $weight <= 0) {
            header("Location: add_product.php?error=invalid_input");
            exit();
        }
        $stmt = $mysqli->prepare("INSERT INTO products (sku, name, price, product_type, weight) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdsi", $sku, $name, $price, $productType, $weight);
        break;

    case 'furniture':
        $height = trim($_POST['height']);
        $width = trim($_POST['width']);
        $length = trim($_POST['length']);

        if (
            empty($height) || !is_numeric($height) || $height <= 0 ||
            empty($width) || !is_numeric($width) || $width <= 0 ||
            empty($length) || !is_numeric($length) || $length <= 0
        ) {
            header("Location: add_product.php?error=invalid_input");
            exit();
        }

        $stmt = $mysqli->prepare("INSERT INTO products (sku, name, price, product_type, height, width, length) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdsddd", $sku, $name, $price, $productType, $height, $width, $length);
        break;

    default:
        header("Location: add_product.php?error=invalid_input");
        exit();
}

// Execute the statement
if ($stmt->execute()) {
    $stmt->close();
    $mysqli->close();
    header("Location: index.php?status=added");
    exit();
} else {
    $stmt->close();
    $mysqli->close();
    header("Location: add_product.php?error=invalid_input");
    exit();
}
?>