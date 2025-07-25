<?php
include "config/db.php";
$result = mysqli_query($conn, "SELECT * FROM products ORDER BY id ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Product List</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
  <div class="card shadow">
    <div class="card-header bg-dark text-white">
      <h4>📦 Product List (User View)</h4>
    </div>
    <div class="card-body table-responsive">
      <?php if (isset($_GET['deleted'])): ?>
        <div class="alert alert-danger">🗑️ Product deleted successfully.</div>
      <?php endif; ?>

      <table class="table table-hover align-middle">
        <thead class="table-dark">
          <tr>
            <th>ID</th>
            <th>Brand</th>
            <th>Model</th>
            <th>Price (₹)</th>
            <th>Description</th>
            <th>Images</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
        <?php while($row = mysqli_fetch_assoc($result)): ?>
          <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['brand'] ?></td>
            <td><?= $row['model'] ?></td>
            <td><?= $row['price'] ?></td>
            <td><?= $row['description'] ?></td>
            <td>
              <div class="d-flex flex-wrap gap-1">
                <img src="uploads/<?= $row['image1'] ?>" width="60" height="60" class="img-thumbnail">
                <img src="uploads/<?= $row['image2'] ?>" width="60" height="60" class="img-thumbnail">
                <img src="uploads/<?= $row['image3'] ?>" width="60" height="60" class="img-thumbnail">
              </div>
            </td>
            <td>
              <a href="update.php?id=<?= $row['id'] ?>&from=products" class="btn btn-sm btn-primary">Edit</a>
              <a href="delete.php?id=<?= $row['id'] ?>&from=products" class="btn btn-sm btn-danger" onclick="return confirm('Delete this product?')">Delete</a>
            </td>
          </tr>
        <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

</body>
</html>
