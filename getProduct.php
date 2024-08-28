<?php

class getProduct {
    private $db;

    public function __construct(Database $database) {
        $this->db = $database->getConnection();
    }

    public function getAllProducts() {
        $query = "SELECT id, sku, name, price, product_type, size, weight, height, width, length FROM products";
        $result = $this->db->query($query);

        if ($result === false) {
            throw new Exception('Query Error: ' . $this->db->error);
        }

        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }

        return $products;
    }

    public function closeConnection() {
        $this->db->close();
    }
}
?>
