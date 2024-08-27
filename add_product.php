<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="style/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>

    </style>
</head>

<body>
    <div class="container">
        <form id="product_form" action="save_product.php" method="post">
            <div class="header d-flex justify-content-between align-items-center mb-4">
                <h1>Add Product</h1>
                <div>

                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href="index.php" class="btn btn-secondary">Cancel</a>
                </div>
            </div>

            <!-- Display Error Message if Exists -->
            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-danger">
                    <?php echo "Error: " . htmlspecialchars($_GET['error']); ?>
                    <?php
                    switch ($_GET['error']) {
                        case 'sku_exists':
                            echo "The SKU already exists. Please enter a unique SKU.";
                            break;
                        case 'invalid_input':
                            echo "Invalid input data. Please check your entries.";
                            break;
                        default:
                            echo "An unexpected error occurred. Please try again.";
                    }
                    ?>
                </div>
            <?php endif; ?>

            <div class="row">
                <div class="col-12 col-md-6">

                    <form id="product_form" novalidate>
                        <div class="mb-3 d-flex align-items-center">
                            <label for="sku" class="form-label me-2">SKU</label>
                            <input type="text" class="form-control" id="sku" name="sku" required>
                            <div class="invalid-feedback">
                                Please provide a SKU.
                            </div>
                        </div>

                        <div class="mb-3 d-flex align-items-center">
                            <label for="name" class="form-label me-2">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                            <div class="invalid-feedback">
                                Please provide a name.
                            </div>
                        </div>

                        <div class="mb-3 d-flex align-items-center">
                            <label for="price" class="form-label me-2">Price ($)</label>
                            <input type="number" step="0.01" class="form-control" id="price" name="price" required>
                            <div class="invalid-feedback">
                                Please provide a valid price.
                            </div>
                        </div>

                        <div class="mb-3 d-flex align-items-center">
                            <label for="productType" class="form-label me-2">Product Type</label>
                            <select class="form-select" id="productType" name="product_type" required>
                                <option value="">Select Type</option>
                                <option value="dvd">DVD</option>
                                <option value="book">Book</option>
                                <option value="furniture">Furniture</option>
                            </select>
                            <div class="invalid-feedback">
                                Please select a product type.
                            </div>
                        </div>

                        <div id="productAttributes" class="mb-3"></div>

                        <div id="validationMessage" class="alert alert-danger hidden"></div>

                    </form>
                </div>
            </div>
        </form>
    </div>

    <!-- Bootstrap JS and Dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const productTypeElement = document.getElementById('productType');
            const productAttributesElement = document.getElementById('productAttributes');
            const form = document.getElementById('product_form');
            const validationMessage = document.getElementById('validationMessage');

            productTypeElement.addEventListener('change', function() {
                const productType = this.value;
                productAttributesElement.innerHTML = '';

                switch (productType) {
                    case 'dvd':
                        productAttributesElement.innerHTML = `
                            <div class="mb-3 d-flex align-items-center">
                                <label for="size" class="form-label me-2">Size (MB)</label>
                                <input type="number" step="0.01" class="form-control" id="size" name="size" required>
                                <div class="invalid-feedback">
                                    Please provide the size in MB.
                                </div>
                            </div>
                            <small class="form-text text-muted">Please provide size in MB format.</small>
                        `;
                        break;
                    case 'book':
                        productAttributesElement.innerHTML = `
                            <div class="mb-3 d-flex align-items-center">
                                <label for="weight" class="form-label me-2">Weight (KG)</label>
                                <input type="number" step="0.01" class="form-control" id="weight" name="weight" required>
                                <div class="invalid-feedback">
                                    Please provide the weight in KG.
                                </div>
                            </div>
                            <small class="form-text text-muted">Please provide weight in KG format.</small>
                        `;
                        break;
                    case 'furniture':
                        productAttributesElement.innerHTML = `
                            <div class="mb-3 d-flex align-items-center">
                                <label for="height" class="form-label me-2">Height (CM)</label>
                                <input type="number" step="0.01" class="form-control" id="height" name="height" required>
                                <div class="invalid-feedback">
                                    Please provide the height in CM.
                                </div>
                            </div>
                            <div class="mb-3 d-flex align-items-center">
                                <label for="width" class="form-label me-2">Width (CM)</label>
                                <input type="number" step="0.01" class="form-control" id="width" name="width" required>
                                <div class="invalid-feedback">
                                    Please provide the width in CM.
                                </div>
                            </div>
                            <div class="mb-3 d-flex align-items-center">
                                <label for="length" class="form-label me-2">Length (CM)</label>
                                <input type="number" step="0.01" class="form-control" id="length" name="length" required>
                                <div class="invalid-feedback">
                                    Please provide the length in CM.
                                </div>
                            </div>
                                <small class="form-text text-muted">Please provide dimensions in HxWxL format.</small>

                        `;
                        break;
                }
            });

            form.addEventListener('submit', function(event) {
                event.preventDefault();
                validationMessage.classList.add('hidden');
                const formData = new FormData(form);
                const productType = formData.get('product_type');

                // Client-side validation
                if (!form.checkValidity()) {
                    form.classList.add('was-validated');
                    return;
                }

                // Additional validation for product attributes
                let isValid = true;
                switch (productType) {
                    case 'dvd':
                        const size = formData.get('size');
                        if (size <= 0) {
                            isValid = false;
                            validationMessage.textContent = 'Size must be a positive number.';
                        }
                        break;
                    case 'book':
                        const weight = formData.get('weight');
                        if (weight <= 0) {
                            isValid = false;
                            validationMessage.textContent = 'Weight must be a positive number.';
                        }
                        break;
                    case 'furniture':
                        const height = formData.get('height');
                        const width = formData.get('width');
                        const length = formData.get('length');
                        if (height <= 0 || width <= 0 || length <= 0) {
                            isValid = false;
                            validationMessage.textContent = 'Dimensions must be positive numbers.';
                        }
                        break;
                    default:
                        isValid = false;
                        validationMessage.textContent = 'Please select a valid product type and provide necessary attributes.';
                }

                if (!isValid) {
                    validationMessage.classList.remove('hidden');
                    return;
                }

                // Submit the form if all validations pass
                form.submit();
            });
        });
    </script>
</body>

</html>