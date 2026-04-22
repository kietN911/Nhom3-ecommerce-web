<?php
require 'db_connect.php';
$data = json_decode(file_get_contents("php://input"));

if(isset($data->order) && isset($data->details)) {
    $order = $data->order;
    $details = $data->details;

    // Insert Đơn hàng
    $sql = "INSERT INTO orders (id, user_id, fullname, phone, address, total_money, note, shipping_method, status) 
            VALUES ('$order->id', '$order->user_id', '$order->fullname', '$order->phone', '$order->address', $order->total_money, '$order->note', '$order->shipping_method', 0)";
    
    if ($conn->query($sql) === TRUE) {
        // Insert Chi tiết
        foreach($details as $item) {
            $sql_det = "INSERT INTO order_details (order_id, product_id, quantity, price, note) 
                        VALUES ('$order->id', $item->id, $item->soluong, $item->price, '$item->note')";
            $conn->query($sql_det);
        }
        echo json_encode(["status" => "success", "message" => "Đặt hàng F&K FOOD thành công!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Lỗi: " . $conn->error]);
    }
}
$conn->close();
?>