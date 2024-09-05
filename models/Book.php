<?php

require_once 'Product.php';

class Book extends Product {
    private $weight;

    public function __construct($sku, $name, $price, $weight, $conn) {
        parent::__construct($sku, $name, $price, 'book', $conn);
        $this->setWeight($weight);
    }

    public function setWeight($weight) {
        if (empty($weight) || !is_numeric($weight) || $weight <= 0) {
            throw new Exception("Invalid input for weight.");
        }
        $this->weight = $weight;
    }

    public function getWeight() {
        return $this->weight;
    }

    public function save() {
        $this->validate();

        $stmt = $this->conn->prepare("INSERT INTO products (sku, name, price, product_type, weight) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param(
            "ssdsi", 
            $this->getSku(), 
            $this->getName(), 
            $this->getPrice(), 
            $this->getProductType(), 
            $this->getWeight()
        );
        $stmt->execute();
        $stmt->close();
    }
}