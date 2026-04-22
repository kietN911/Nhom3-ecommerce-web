<?php
$conn = new mysqli("localhost", "root", "", "fk_food");
$conn->set_charset("utf8mb4");
if ($conn->connect_error) { die(json_encode(["status" => "error", "message" => "Lỗi kết nối DB"])); }
?>