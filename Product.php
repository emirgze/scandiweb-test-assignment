<?php
/*
require_once 'Database.php';

class Product {
    private $sku;
    private $name;
    private $price;
    private $productType;
    private $conn;

    // Additional attributes for specific product types
    private $height;
    private $width;
    private $length;
    private $size;
    private $weight;

    public function __construct($sku, $name, $price, $productType, $conn, $attributes = []) {
        $this->sku = $sku;
        $this->name = $name;
        $this->price = $price;
        $this->productType = $productType;
        $this->conn = $conn;

        // Initialize specific attributes based on product type
        $this->setAttributes($attributes);
    }

    private function setAttributes($attributes) {
        if ($this->productType === 'furniture') {
            $this->height = $attributes['height'] ?? null;
            $this->width = $attributes['width'] ?? null;
            $this->length = $attributes['length'] ?? null;
        } elseif ($this->productType === 'dvd') {
            $this->size = $attributes['size'] ?? null;
        } elseif ($this->productType === 'book') {
            $this->weight = $attributes['weight'] ?? null;
        }
    }

    private function validate() {
        if (empty($this->sku) || empty($this->name) || empty($this->price) || empty($this->productType)) {
            throw new Exception("Please submit required data.");
        }

        $stmt = $this->conn->prepare("SELECT id FROM products WHERE sku = ?");
        $stmt->bind_param("s", $this->sku);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->close();
            throw new Exception("SKU already exists. Please enter a unique SKU.");
        }

        $stmt->close();
    }

    public function save() {
        $this->validate();
        $sql = $this->getInsertSQL();
        $stmt = $this->conn->prepare($sql);

        if ($stmt === false) {
            throw new Exception('Prepare Error: ' . $this->conn->error);
        }

        $this->bindParams($stmt);

        if (!$stmt->execute()) {
            throw new Exception('Execute Error: ' . $stmt->error);
        }

        $stmt->close();
    }

    private function getInsertSQL() {
        switch ($this->productType) {
            case 'furniture':
                return "INSERT INTO products (sku, name, price, product_type, height, width, length) VALUES (?, ?, ?, ?, ?, ?, ?)";
            case 'dvd':
                return "INSERT INTO products (sku, name, price, product_type, size) VALUES (?, ?, ?, ?, ?)";
            case 'book':
                return "INSERT INTO products (sku, name, price, product_type, weight) VALUES (?, ?, ?, ?, ?)";
            default:
                throw new Exception("Invalid product type.");
        }
    }

    private function bindParams($stmt) {
        switch ($this->productType) {
            case 'furniture':
                $stmt->bind_param("ssdsddd", $this->sku, $this->name, $this->price, $this->productType, $this->height, $this->width, $this->length);
                break;
            case 'dvd':
                $stmt->bind_param("ssdsi", $this->sku, $this->name, $this->price, $this->productType, $this->size);
                break;
            case 'book':
                $stmt->bind_param("ssdsi", $this->sku, $this->name, $this->price, $this->productType, $this->weight);
                break;
        }
    }
}
?>
*/

require_once 'Database.php';

abstract class Product {
    protected $sku;
    protected $name;
    protected $price;
    protected $productType;
    protected $conn;

    public function __construct($sku, $name, $price, $productType, $conn) {
        $this->sku = $sku;
        $this->name = $name;
        $this->price = $price;
        $this->productType = $productType;
        $this->conn = $conn;
    }

    public function validate() {
        if (empty($this->sku) || empty($this->name) || empty($this->price) || empty($this->productType)) {
            throw new Exception("Please submit required data.");
        }

        $stmt = $this->conn->prepare("SELECT id FROM products WHERE sku = ?");
        $stmt->bind_param("s", $this->sku);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            throw new Exception("SKU already exists. Please enter a unique SKU.");
        }

        $stmt->close();
    }

    abstract public function save();
}
?>
