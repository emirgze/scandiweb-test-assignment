<?php
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
