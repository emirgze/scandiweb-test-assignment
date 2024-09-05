<?php

require_once 'Product.php';

class Furniture extends Product {
    private $height;
    private $width;
    private $length;

    public function __construct($sku, $name, $price, $height, $width, $length, $conn) {
        parent::__construct($sku, $name, $price, 'furniture', $conn);
        $this->setHeight($height);
        $this->setWidth($width);
        $this->setLength($length);
    }

    public function setHeight($height) {
        if (empty($height) || !is_numeric($height) || $height <= 0) {
            throw new Exception("Invalid input for height.");
        }
        $this->height = $height;
    }

    public function setWidth($width) {
        if (empty($width) || !is_numeric($width) || $width <= 0) {
            throw new Exception("Invalid input for width.");
        }
        $this->width = $width;
    }

    public function setLength($length) {
        if (empty($length) || !is_numeric($length) || $length <= 0) {
            throw new Exception("Invalid input for length.");
        }
        $this->length = $length;
    }

    public function getHeight() {
        return $this->height;
    }

    public function getWidth() {
        return $this->width;
    }

    public function getLength() {
        return $this->length;
    }

    public function save() {
        $this->validate();

        $stmt = $this->conn->prepare("INSERT INTO products (sku, name, price, product_type, height, width, length) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param(
            "ssdsddd", 
            $this->getSku(), 
            $this->getName(), 
            $this->getPrice(), 
            $this->getProductType(), 
            $this->getHeight(), 
            $this->getWidth(), 
            $this->getLength()
        );
        $stmt->execute();
        $stmt->close();
    }
}
