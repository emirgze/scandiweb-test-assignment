<?php
require_once('Database.php');
/*
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

// Get the product ID from POST
$product_id = isset($_POST['id']) ? intval($_POST['id']) : 0;

if ($product_id <= 0) {
    die('Invalid Product ID');
}

// Prepare and execute the DELETE statement
$sql = "DELETE FROM products WHERE id = ?";
$stmt = mysqli_prepare($_db_conn, $sql);

if ($stmt === false) {
    die('Prepare Error: ' . mysqli_error($_db_conn));
}

// Bind parameters
mysqli_stmt_bind_param($stmt, "i", $product_id);

// Execute the statement
if (mysqli_stmt_execute($stmt)) {
    // Redirect to the product list page
    header("Location: index.php?status=deleted");
} else {
    echo "Execute Error: " . mysqli_stmt_error($stmt);
}

// Close the statement and connection
mysqli_stmt_close($stmt);
mysqli_close($_db_conn);
exit();
?>
*/




// class MassDelete {
//     private $db;

//     public function __construct(Database $database) {
//         $this->db = $database->getConnection();
//     }

//     public function deleteProducts(array $productIds) {
//         if (empty($productIds)) {
//             throw new Exception('No products selected for deletion.');
//         }

//         // Prepare the DELETE statement with placeholders
//         $placeholders = implode(',', array_fill(0, count($productIds), '?'));
//         $sql = "DELETE FROM products WHERE id IN ($placeholders)";
//         $stmt = $this->db->prepare($sql);

//         if ($stmt === false) {
//             throw new Exception('Prepare Error: ' . $this->db->error);
//         }

//         // Bind parameters
//         $types = str_repeat('i', count($productIds));
//         $stmt->bind_param($types, ...$productIds);

//         // Execute the statement
//         if (!$stmt->execute()) {
//             throw new Exception('Execute Error: ' . $stmt->error);
//         }

//         // Close the statement
//         $stmt->close();
//     }
// }
// ?>



