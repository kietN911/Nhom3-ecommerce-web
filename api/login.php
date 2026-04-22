<?php
require 'db_connect.php';
$data = json_decode(file_get_contents("php://input"));
if(isset($data->phone) && isset($data->password)) {
    $phone = $conn->real_escape_string($data->phone);
    $pass = $data->password; 
    // Lưu ý: Thực tế nên mã hóa password, ở đây làm đơn giản so sánh chuỗi
    $sql = "SELECT * FROM users WHERE phone = '$phone' AND password = '$pass' AND status = 1";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        unset($user['password']); // Xóa pass trước khi trả về
        $user['cart'] = []; // Tạo giỏ hàng rỗng
        echo json_encode(["status" => "success", "user" => $user]);
    } else {
        echo json_encode(["status" => "error", "message" => "Sai tài khoản hoặc mật khẩu!"]);
    }
}
$conn->close();
?>