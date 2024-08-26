<?php
// require_once('config/db/config.php.php');

define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_DATABASE", "scandiweb");

// Connection
$_db_conn = @mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);

if (!$_db_conn) {
    die('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
}

// Change character set to utf8
if (!mysqli_set_charset($_db_conn, "utf8")) {
    printf("Error loading character set utf8: %s\n", mysqli_error($_db_conn));
}

// Prepare SQL statement
$sql = "INSERT INTO products (sku, name, price, product_type, size, weight, height, width, length) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($_db_conn, $sql);

if ($stmt === false) {
    die('Prepare Error: ' . mysqli_error($_db_conn));
}

// Bind parameters
mysqli_stmt_bind_param($stmt, "ssdssssss", $sku, $name, $price, $productType, $size, $weight, $height, $width, $length);

// Set parameters and execute
$sku = $_POST['sku'];
$name = $_POST['name'];
$price = $_POST['price'];
$productType = $_POST['productType'];

// Handle optional fields based on product type
if ($productType === 'dvd') {
    $size = $_POST['size'];
    $weight = null;
    $height = null;
    $width = null;
    $length = null;
} elseif ($productType === 'book') {
    $size = null;
    $weight = $_POST['weight'];
    $height = null;
    $width = null;
    $length = null;
} elseif ($productType === 'furniture') {
    $size = null;
    $weight = null;
    $height = $_POST['height'];
    $width = $_POST['width'];
    $length = $_POST['length'];
} else {
    die('Invalid product type');
}

// Execute the statement
if (mysqli_stmt_execute($stmt)) {
    echo "Product saved successfully.";
} else {
    echo "Execute Error: " . mysqli_stmt_error($stmt);
}

// Close the statement and connection
mysqli_stmt_close($stmt);
mysqli_close($_db_conn);

// Redirect or handle post-save logic here
header("Location: index.php");
exit();
?>
