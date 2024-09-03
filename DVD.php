<?php

require_once 'Product.php';

class DVD extends Product {
    private $size;

    public function __construct($sku, $name, $price, $size, $conn) {
        parent::__construct($sku, $name, $price, 'dvd', $conn);
        $this->size = $size;
    }

    public function save() {
        $this->validate();

        if (empty($this->size) || !is_numeric($this->size) || $this->size <= 0) {
            throw new Exception("Invalid input for size.");
        }

        $stmt = $this->conn->prepare("INSERT INTO products (sku, name, price, product_type, size) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdsi", $this->sku, $this->name, $this->price, $this->productType, $this->size);
        $stmt->execute();
        $stmt->close();
    }
}
?>
