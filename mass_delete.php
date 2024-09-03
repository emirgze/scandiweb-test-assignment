<?php
require_once 'Database.php';


class MassDelete {
    private $db;

    public function __construct(Database $database) {
        $this->db = $database->getConnection();
    }

    public function deleteProducts(array $productIds) {
        if (empty($productIds)) {
            throw new Exception('No products selected for deletion.');
        }

        // Prepare the DELETE statement with placeholders
        $placeholders = implode(',', array_fill(0, count($productIds), '?'));
        $sql = "DELETE FROM products WHERE id IN ($placeholders)";
        $stmt = $this->db->prepare($sql);

        if ($stmt === false) {
            throw new Exception('Prepare Error: ' . $this->db->error);
        }

        // Bind parameters
        $types = str_repeat('i', count($productIds));
        $stmt->bind_param($types, ...$productIds);

        // Execute the statement
        if (!$stmt->execute()) {
            throw new Exception('Execute Error: ' . $stmt->error);
        }

        // Close the statement
        $stmt->close();
    }
}

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

