<?php
include_once "config/db.php";

$id = $_GET['id'] ?? 0;
$product = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM products WHERE id = $id"));

// Handle form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    // File Upload Logic
    $uploadDir = "uploads/";
    $img1 = $product['image1'];
    $img2 = $product['image2'];
    $img3 = $product['image3'];

    if (!empty($_FILES['image1']['name'])) {
        $img1 = time() . "_1_" . basename($_FILES['image1']['name']);
        move_uploaded_file($_FILES['image1']['tmp_name'], $uploadDir . $img1);
    }

    if (!empty($_FILES['image2']['name'])) {
        $img2 = time() . "_2_" . basename($_FILES['image2']['name']);
        move_uploaded_file($_FILES['image2']['tmp_name'], $uploadDir . $img2);
    }

    if (!empty($_FILES['image3']['name'])) {
        $img3 = time() . "_3_" . basename($_FILES['image3']['name']);
        move_uploaded_file($_FILES['image3']['tmp_name'], $uploadDir . $img3);
    }

    $sql = "UPDATE products SET 
            brand='$brand', 
            model='$model', 
            price='$price', 
            description='$description',
            image1='$img1',
            image2='$img2',
            image3='$img3'
            WHERE id=$id";

    if (mysqli_query($conn, $sql)) {
        $from = $_GET['from'] ?? 'dashboard';
        $redirectPage = ($from === 'products') ? 'products.php' : 'dashboard.php';
        header("Location: $redirectPage?updated=1");
        exit;
    } else {
        echo "Error updating: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Update Product</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
  <div class="card shadow">
    <div class="card-header bg-primary text-white">
      <h4>✏️ Update Product (ID: <?= $product['id'] ?>)</h4>
    </div>
    <div class="card-body">
      <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
          <label class="form-label">Brand</label>
          <select name="brand" class="form-select" required>
            <option value="">Select Brand</option>
            <option value="Apple" <?= $product['brand'] === 'Apple' ? 'selected' : '' ?>>Apple</option>
            <option value="Samsung" <?= $product['brand'] === 'Samsung' ? 'selected' : '' ?>>Samsung</option>
            <option value="OnePlus" <?= $product['brand'] === 'OnePlus' ? 'selected' : '' ?>>OnePlus</option>
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label">Model</label>
          <input type="text" name="model" class="form-control" value="<?= $product['model'] ?>" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Price</label>
          <input type="text" name="price" class="form-control" value="<?= $product['price'] ?>" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Description</label>
          <textarea name="description" class="form-control" rows="3"><?= $product['description'] ?></textarea>
        </div>

        <div class="mb-3">
          <label class="form-label">Image 1</label><br>
          <img src="uploads/<?= $product['image1'] ?>" width="100" class="mb-2"><br>
          <input type="file" name="image1" class="form-control">
        </div>

        <div class="mb-3">
          <label class="form-label">Image 2</label><br>
          <img src="uploads/<?= $product['image2'] ?>" width="100" class="mb-2"><br>
          <input type="file" name="image2" class="form-control">
        </div>

        <div class="mb-3">
          <label class="form-label">Image 3</label><br>
          <img src="uploads/<?= $product['image3'] ?>" width="100" class="mb-2"><br>
          <input type="file" name="image3" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Update Product</button>
        <a href="<?= ($_GET['from'] ?? '') === 'products' ? 'products.php' : 'dashboard.php' ?>" class="btn btn-secondary">Cancel</a>
      </form>
    </div>
  </div>
</div>

</body>
</html>
