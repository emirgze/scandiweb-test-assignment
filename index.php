<?php
require_once('config/db/connection.php');

// define("DB_HOST", "localhost");
// define("DB_USER", "root");
// define("DB_PASS", "");
// define("DB_DATABASE", "scandiweb");

// // Connection
// $_db_conn = @mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);

// if (!$_db_conn) {
//     die('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
// }

// // Change character set to utf8
// if (!mysqli_set_charset($_db_conn, "utf8")) {
//     printf("Error loading character set utf8: %s\n", mysqli_error($_db_conn));
// }

// Fetch products
$query = "SELECT id, sku, name, price, product_type, size, weight, height, width, length FROM products";
$result = mysqli_query($_db_conn, $query);

if (!$result) {
    die('Query Error: ' . mysqli_error($_db_conn));
}

// Fetch all products
$products = [];
while ($row = mysqli_fetch_assoc($result)) {
    $products[] = $row;
}

// Close the connection
mysqli_close($_db_conn);
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="header d-flex align-items-center justify-content-between">
                        <h1>Product List</h1>
                        <div class="text-right">
                            <form action="add_product.php" method="get" style="display:inline;">
                                <button type="submit" class="btn btn-primary">Add</button>
                            </form>
                            <form action="mass_delete.php" method="post" style="display:inline;">
                                <button type="submit" class="btn btn-danger">Mass Delete</button>
                                <!-- </form> -->


                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <!-- <form action="mass_delete.php" method="post"> -->
                    <div class="d-flex flex-wrap">
                        <?php foreach ($products as $product): ?>
                            <div class="card me-3 mb-3" style="width: 16rem;">
                                <div class="card-body">
                                    <div class="form-check mb-2 float-start">
                                        <input class="form-check-input" type="checkbox" name="product_ids[]" value="<?php echo htmlspecialchars($product['id']); ?>" id="cardCheckbox<?php echo htmlspecialchars($product['id']); ?>">
                                        <label class="form-check-label" for="cardCheckbox<?php echo htmlspecialchars($product['id']); ?>"></label>
                                    </div>
                                    <h5 class="card-title text-center"><?php echo htmlspecialchars($product['name']); ?></h5>
                                    <h6 class="card-subtitle text-center mb-2 text-muted"><?php echo htmlspecialchars($product['sku']); ?></h6>
                                    <p class="card-text  text-center">Price: $<?php echo htmlspecialchars(number_format($product['price'], 2)); ?></p>
                                    <?php if ($product['product_type'] === 'dvd'): ?>
                                        <p class="card-text text-center">Size: <?php echo htmlspecialchars($product['size']); ?> MB</p>
                                    <?php elseif ($product['product_type'] === 'book'): ?>
                                        <p class="card-text text-center">Weight: <?php echo htmlspecialchars($product['weight']); ?> Kg</p>
                                    <?php elseif ($product['product_type'] === 'furniture'): ?>
                                        <p class="card-text text-center">Dimensions: <?php echo htmlspecialchars($product['height']); ?>x<?php echo htmlspecialchars($product['width']); ?>x<?php echo htmlspecialchars($product['length']); ?> cm</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- <div class="text-right mt-3">
                        <button type="submit" class="btn btn-danger">Mass Delete</button>
                    </div> -->
                    </form>
                </div>
                <div class="col-12">
                    <footer class="py-3 text-center footer">
                        <p>Scandiweb Test assignment</p>
                    </footer>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>