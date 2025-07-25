<?php
include_once "config/db.php";

$id = $_GET['id'] ?? 0;
$from = $_GET['from'] ?? 'dashboard';

$sql = "DELETE FROM products WHERE id = $id";

if (mysqli_query($conn, $sql)) {
    if ($from === 'products') {
        header("Location: products.php?deleted=1");
    } else {
        header("Location: dashboard.php?deleted=1");
    }
} else {
    echo "Error deleting record: " . mysqli_error($conn);
}
?>
