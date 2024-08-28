<?php
// require_once('config/db/connection.php');
require_once 'Database.php';
require_once 'Delete.php';

// require_once 'Delete.php';


// define("DB_HOST", "localhost");
// define("DB_USER", "root");
// define("DB_PASS", "");
// define("DB_DATABASE", "scandiweb");

// // Connection
// $_db_conn = @mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);

// if (!$_db_conn) {
//     die('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
// }

// // Change character set to utf8
// if (!mysqli_set_charset($_db_conn, "utf8")) {
//     printf("Error loading character set utf8: %s\n", mysqli_error($_db_conn));
// }







// Get the array of product IDs from POST
// $product_ids = isset($_POST['product_ids']) ? $_POST['product_ids'] : [];

// if (empty($product_ids)) {
//     die('No products selected for deletion.');
// }

// // Prepare and execute the DELETE statement
// $placeholders = implode(',', array_fill(0, count($product_ids), '?'));
// $sql = "DELETE FROM products WHERE id IN ($placeholders)";
// $stmt = mysqli_prepare($_db_conn, $sql);

// if ($stmt === false) {
//     die('Prepare Error: ' . mysqli_error($_db_conn));
// }

// // Bind parameters
// mysqli_stmt_bind_param($stmt, str_repeat('i', count($product_ids)), ...$product_ids);

// // Execute the statement
// if (mysqli_stmt_execute($stmt)) {
//     // Redirect to the product list page
//     header("Location: index.php?status=deleted");
// } else {
//     echo "Execute Error: " . mysqli_stmt_error($stmt);
// }

// // Close the statement and connection
// mysqli_stmt_close($stmt);
// mysqli_close($_db_conn);
// exit();




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

// Usage
try {
    $database = new Database();
    $massDelete = new MassDelete($database);

    $productIds = isset($_POST['product_ids']) ? $_POST['product_ids'] : [];
    $massDelete->deleteProducts($productIds);

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


?>

