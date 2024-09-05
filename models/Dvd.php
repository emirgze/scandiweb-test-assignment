<?php

require_once 'Product.php';

class Dvd extends Product {
    private $size;

    public function __construct($sku, $name, $price, $size, $conn) {
        parent::__construct($sku, $name, $price, 'dvd', $conn);
        $this->setSize($size);
    }

    public function setSize($size) {
        if (empty($size) || !is_numeric($size) || $size <= 0) {
            throw new Exception("Invalid input for size.");
        }
        $this->size = $size;
    }

    public function getSize() {
        return $this->size;
    }

    public function save() {
        $this->validate();

        $stmt = $this->conn->prepare("INSERT INTO products (sku, name, price, product_type, size) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param(
            "ssdsi", 
            $this->getSku(), 
            $this->getName(), 
            $this->getPrice(), 
            $this->getProductType(), 
            $this->getSize()
        );
        $stmt->execute();
        $stmt->close();
    }
}
