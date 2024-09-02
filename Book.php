<?php

require_once 'Product.php';

class Book extends Product {
    private $weight;

    public function __construct($sku, $name, $price, $weight, $conn) {
        parent::__construct($sku, $name, $price, 'book', $conn);
        $this->weight = $weight;
    }

    public function save() {
        $this->validate();

        if (empty($this->weight) || !is_numeric($this->weight) || $this->weight <= 0) {
            throw new Exception("Invalid input for weight.");
        }

        $stmt = $this->conn->prepare("INSERT INTO products (sku, name, price, product_type, weight) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdsi", $this->sku, $this->name, $this->price, $this->productType, $this->weight);
        $stmt->execute();
        $stmt->close();
    }
}
?>



