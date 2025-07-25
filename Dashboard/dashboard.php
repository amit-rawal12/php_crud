<?php
if (isset($_GET['updated'])) {
  echo "<div class='alert alert-success mt-3'>Product updated successfully.</div>";
}
if (isset($_GET['deleted'])) {
  echo "<div class='alert alert-danger mt-3'>Product deleted successfully.</div>";
}

session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}

include_once "../config/db.php"; // ✅ FIXED PATH

$sql = "SELECT * FROM products ORDER BY id DESC";
$result = mysqli_query($conn, $sql);  
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="text-dark">📊 Admin Dashboard</h2>
    <a href="index.php" class="btn btn-primary">+ Add New Product</a>
    <a href="logout.php" class="btn btn-danger">Logout</a>


  </div>

  <div class="card shadow">
    <div class="card-header bg-dark text-white">Product Management</div>
    <div class="card-body">
      <table class="table table-bordered table-striped">
        <thead class="table-dark">
          <tr>
            <th>ID</th>
            <th>Brand</th>
            <th>Model</th>
            <th>Price</th>
            <th>Description</th>
            <th>Images</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
include_once "../config/db.php";
          $sql = "SELECT * FROM products ORDER BY id DESC";
          $result = mysqli_query($conn, $sql);

          while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>{$row['id']}</td>";
            echo "<td>{$row['brand']}</td>";
            echo "<td>{$row['model']}</td>";
            echo "<td>{$row['price']}</td>";
            echo "<td>{$row['description']}</td>";
            echo "<td>";
            echo "<img src='uploads/{$row['image1']}' width='50'>";
            echo "<img src='uploads/{$row['image2']}' width='50'>";
            echo "<img src='uploads/{$row['image3']}' width='50'>";
            echo "</td>";
            echo "<td>
                    <a href='update.php?id={$row['id']}' class='btn btn-sm btn-warning'>Edit</a>
                    <a href='delete.php?id={$row['id']}' onclick='return confirm(\"Are you sure?\")' class='btn btn-sm btn-danger'>Delete</a>
                  </td>";
            echo "</tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

</body>
</html>
