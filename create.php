<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json");

include_once "config/db.php";

$brand = $_POST['brand'] ?? '';
$model = $_POST['model'] ?? '';
$price = $_POST['price'] ?? '';
$description = $_POST['description'] ?? '';

// Upload folder
$targetDir = "uploads/";
if (!is_dir($targetDir)) {
    mkdir($targetDir);
}

// Handle images
$image1 = $_FILES['image1']['name'] ?? '';
$image2 = $_FILES['image2']['name'] ?? '';
$image3 = $_FILES['image3']['name'] ?? '';

$tmp1 = $_FILES['image1']['tmp_name'] ?? '';
$tmp2 = $_FILES['image2']['tmp_name'] ?? '';
$tmp3 = $_FILES['image3']['tmp_name'] ?? '';

$path1 = $targetDir . time() . "_1_" . basename($image1);
$path2 = $targetDir . time() . "_2_" . basename($image2);
$path3 = $targetDir . time() . "_3_" . basename($image3);

// Move files
move_uploaded_file($tmp1, $path1);
move_uploaded_file($tmp2, $path2);
move_uploaded_file($tmp3, $path3);

// Save filenames
$db_image1 = basename($path1);
$db_image2 = basename($path2);
$db_image3 = basename($path3);

// DB Query
$sql = "INSERT INTO products (brand, model, price, description, image1, image2, image3)
        VALUES ('$brand', '$model', '$price', '$description', '$db_image1', '$db_image2', '$db_image3')";

if (mysqli_query($conn, $sql)) {
    echo json_encode(["status" => "success", "message" => "Product created successfully."]);
} else {
    echo json_encode(["status" => "error", "message" => mysqli_error($conn)]);
}
?>
