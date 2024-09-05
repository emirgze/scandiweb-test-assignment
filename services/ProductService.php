<?php

require_once __DIR__ . '/../models/Furniture.php';
require_once __DIR__ . '/../models/Book.php';
require_once __DIR__ . '/../models/Dvd.php';

class ProductService {
    private $db;

    public function __construct(Database $database) {
        $this->db = $database->getConnection();
    }

    public function getAll() {
        $query = "SELECT id, sku, name, price, product_type, size, weight, height, width, length FROM products";
        $result = $this->db->query($query);
    
        if ($result === false) {
            throw new Exception('Query Error: ' . $this->db->error);
        }
    
        $products = [];
        while ($row = $result->fetch_assoc()) {
            // Create associative array for each product based on product type
            switch ($row['product_type']) {
                case 'furniture':
                    $product = new Furniture(
                        $row['sku'],
                        $row['name'],
                        $row['price'],
                        $row['height'],
                        $row['width'],
                        $row['length'],
                        $this->db
                    );
                    $products[] = [
                        'id' => $row['id'],
                        'sku' => $product->getSku(),
                        'name' => $product->getName(),
                        'price' => $product->getPrice(),
                        'product_type' => $product->getProductType(),
                        'height' => $product->getHeight(),
                        'width' => $product->getWidth(),
                        'length' => $product->getLength()
                    ];
                    break;
                case 'dvd':
                    $product = new Dvd(
                        $row['sku'],
                        $row['name'],
                        $row['price'],
                        $row['size'],
                        $this->db
                    );
                    $products[] = [
                        'id' => $row['id'],
                        'sku' => $product->getSku(),
                        'name' => $product->getName(),
                        'price' => $product->getPrice(),
                        'product_type' => $product->getProductType(),
                        'size' => $product->getSize()
                    ];
                    break;
                case 'book':
                    $product = new Book(
                        $row['sku'],
                        $row['name'],
                        $row['price'],
                        $row['weight'],
                        $this->db
                    );
                    $products[] = [
                        'id' => $row['id'],
                        'sku' => $product->getSku(),
                        'name' => $product->getName(),
                        'price' => $product->getPrice(),
                        'product_type' => $product->getProductType(),
                        'weight' => $product->getWeight()
                    ];
                    break;
                default:
                    throw new Exception('Unknown product type: ' . $row['product_type']);
            }
        }
        return $products;
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

    public function closeConnection() {
        if (isset($this->db)) {
            $this->db->closeConnection();
        }
    }
}

