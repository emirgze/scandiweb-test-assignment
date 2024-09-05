<?php

require_once __DIR__ . '/../Database.php';

abstract class Product {
    protected $sku;
    protected $name;
    protected $price;
    protected $productType;
    protected $conn;

    public function __construct($sku, $name, $price, $productType, $conn) {
        $this->setSku($sku);
        $this->setName($name);
        $this->setPrice($price);
        $this->setProductType($productType);
        $this->conn = $conn;
    }

    public function setSku($sku) {
        if (empty($sku)) {
            throw new Exception("SKU is required.");
        }
        $this->sku = $sku;
    }

    public function getSku() {
        return $this->sku;
    }

    public function setName($name) {
        if (empty($name)) {
            throw new Exception("Name is required.");
        }
        $this->name = $name;
    }

    public function getName() {
        return htmlspecialchars($this->name);
    }

    public function setPrice($price) {
        if (empty($price) || !is_numeric($price) || $price <= 0) {
            throw new Exception("Invalid price. Please enter a positive number.");
        }
        $this->price = $price;
    }

    public function getPrice() {
        return htmlspecialchars(number_format($this->price, 2));
    }

    public function setProductType($productType) {
        if (empty($productType)) {
            throw new Exception("Product type is required.");
        }
        $this->productType = $productType;
    }

    public function getProductType() {
        return $this->productType;
    }

    public function validate() {
        if (empty($this->getSku()) || empty($this->getName()) || empty($this->getPrice()) || empty($this->getProductType())) {
            throw new Exception("Please submit required data.");
        }

        $stmt = $this->conn->prepare("SELECT id FROM products WHERE sku = ?");
        $stmt->bind_param("s", $this->getSku());
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            throw new Exception("SKU already exists. Please enter a unique SKU.");
        }

        $stmt->close();
    }

    abstract public function save();
}
