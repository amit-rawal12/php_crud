<?php
include_once "./config/db.php";

$id = $_POST['id'];
$brand = $_POST['brand'];
$model = $_POST['model'];
$price = $_POST['price'];
$description = $_POST['description'];

// Fetch old images
$old = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM products WHERE id=$id"));

// Image paths
$uploadDir = "uploads/";
$image1 = !empty($_FILES['image1']['name']) ? time() . "_1_" . $_FILES['image1']['name'] : $old['image1'];
$image2 = !empty($_FILES['image2']['name']) ? time() . "_2_" . $_FILES['image2']['name'] : $old['image2'];
$image3 = !empty($_FILES['image3']['name']) ? time() . "_3_" . $_FILES['image3']['name'] : $old['image3'];

if (!empty($_FILES['image1']['name'])) move_uploaded_file($_FILES['image1']['tmp_name'], $uploadDir . $image1);
if (!empty($_FILES['image2']['name'])) move_uploaded_file($_FILES['image2']['tmp_name'], $uploadDir . $image2);
if (!empty($_FILES['image3']['name'])) move_uploaded_file($_FILES['image3']['tmp_name'], $uploadDir . $image3);

$sql = "UPDATE products SET 
        brand='$brand',
        model='$model',
        price='$price',
        description='$description',
        image1='$image1',
        image2='$image2',
        image3='$image3'
        WHERE id=$id";

if (mysqli_query($conn, $sql)) {
    header("Location: dashboard.php?updated=1");
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
