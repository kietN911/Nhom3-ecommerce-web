<?php
require 'db_connect.php';

header('Content-Type: application/json; charset=utf-8');

// Nhận JSON
$raw = file_get_contents("php://input");
$data = json_decode($raw);

if (!$data || !isset($data->fullname, $data->phone, $data->password)) {
    echo json_encode(["status" => "error", "message" => "Thiếu dữ liệu!"], JSON_UNESCAPED_UNICODE);
    exit;
}

$fullname = trim($data->fullname);
$phone    = trim($data->phone);
$pass     = $data->password;

if ($fullname === '' || $phone === '' || $pass === '') {
    echo json_encode(["status" => "error", "message" => "Vui lòng nhập đầy đủ thông tin!"], JSON_UNESCAPED_UNICODE);
    exit;
}

// Check trùng phone
$stmt = $conn->prepare("SELECT id FROM users WHERE phone = ? LIMIT 1");
$stmt->bind_param("s", $phone);
$stmt->execute();
$rs = $stmt->get_result();
if ($rs && $rs->num_rows > 0) {
    echo json_encode(["status" => "error", "message" => "Số điện thoại đã tồn tại!"], JSON_UNESCAPED_UNICODE);
    exit;
}
$stmt->close();

// Hash password
$hash = password_hash($pass, PASSWORD_BCRYPT);

// Insert
$stmt = $conn->prepare("INSERT INTO users(fullname, phone, password, status, user_type) VALUES(?, ?, ?, 1, 0)");
$stmt->bind_param("sss", $fullname, $phone, $hash);

if ($stmt->execute()) {
    $newId = $stmt->insert_id;

    echo json_encode([
        "status" => "success",
        "message" => "Đăng ký thành công",
        "user" => [
            "id" => $newId,
            "fullname" => $fullname,
            "phone" => $phone,
            "user_type" => 0
        ]
    ], JSON_UNESCAPED_UNICODE);
} else {
    echo json_encode(["status" => "error", "message" => "Lỗi khi tạo tài khoản!"], JSON_UNESCAPED_UNICODE);
}
$stmt->close();
$conn->close();
exit;
