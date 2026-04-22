<?php
require 'db_connect.php';
$sql = "SELECT * FROM products WHERE status = 1";
$result = $conn->query($sql);
$products = [];
while($row = $result->fetch_assoc()) {
    $row['id'] = (int)$row['id']; // Ép kiểu số để JS hiểu
    $row['price'] = (int)$row['price'];
    $products[] = $row;
}
echo json_encode($products);
$conn->close();
?>