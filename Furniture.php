<?php

require_once 'Product.php';

class Furniture extends Product {
    private $height;
    private $width;
    private $length;

    public function __construct($sku, $name, $price, $height, $width, $length, $conn) {
        parent::__construct($sku, $name, $price, 'furniture', $conn);
        $this->height = $height;
        $this->width = $width;
        $this->length = $length;
    }

    public function save() {
        $this->validate();

        if (empty($this->height) || empty($this->width) || empty($this->length) ||
            !is_numeric($this->height) || $this->height <= 0 ||
            !is_numeric($this->width) || $this->width <= 0 ||
            !is_numeric($this->length) || $this->length <= 0) {
            throw new Exception("Invalid input for dimensions.");
        }

        $stmt = $this->conn->prepare("INSERT INTO products (sku, name, price, product_type, height, width, length) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdsddd", $this->sku, $this->name, $this->price, $this->productType, $this->height, $this->width, $this->length);
        $stmt->execute();
        $stmt->close();
    }
}
?>

