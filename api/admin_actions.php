<?php
// api/admin_actions.php
require 'db_connect.php';
session_start();

// Kiểm tra quyền Admin
// Giả sử session đã lưu user khi login ở bước trước
// if (!isset($_SESSION['current_user']) || $_SESSION['current_user']['user_type'] != 1) {
//     die(json_encode(["status" => "error", "message" => "Không có quyền truy cập!"]));
// }

$action = isset($_GET['action']) ? $_GET['action'] : '';

// 1. XỬ LÝ THÊM / SỬA SẢN PHẨM
if ($action == 'save_product' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['ten-mon'];
    $cat = $_POST['category'];
    $price = $_POST['gia-moi'];
    $desc = $_POST['mo-ta'];
    $id = isset($_POST['id']) ? $_POST['id'] : '';
    
    // Xử lý upload ảnh (Cơ bản)
    $img = './assets/img/products/default.png'; 
    if(isset($_FILES['up-hinh-anh']) && $_FILES['up-hinh-anh']['name'] != "") {
        $target_dir = "../assets/img/products/";
        $target_file = $target_dir . basename($_FILES["up-hinh-anh"]["name"]);
        move_uploaded_file($_FILES["up-hinh-anh"]["tmp_name"], $target_file);
        $img = "./assets/img/products/" . basename($_FILES["up-hinh-anh"]["name"]);
    } else if (isset($_POST['current_img'])) {
        $img = $_POST['current_img'];
    }

    if ($id) {
        // Update
        $sql = "UPDATE products SET title='$title', category='$cat', price='$price', description='$desc', img='$img' WHERE id=$id";
    } else {
        // Insert
        $sql = "INSERT INTO products (title, category, price, description, img, status) VALUES ('$title', '$cat', '$price', '$desc', '$img', 1)";
    }

    if ($conn->query($sql)) {
        header("Location: ../admin.php?msg=success");
    } else {
        echo "Lỗi: " . $conn->error;
    }
}

// 2. XÓA SẢN PHẨM (Xóa mềm)
if ($action == 'delete_product') {
    $id = $_GET['id'];
    $conn->query("UPDATE products SET status = 0 WHERE id=$id");
    header("Location: ../admin.php");
}

// 3. KHÓA / MỞ KHÓA TÀI KHOẢN
if ($action == 'toggle_user') {
    $id = $_GET['id'];
    $current_status = $_GET['status'];
    $new_status = $current_status == 1 ? 0 : 1;
    $conn->query("UPDATE users SET status = $new_status WHERE id=$id");
    header("Location: ../admin.php");
}

// 4. DUYỆT ĐƠN HÀNG
if ($action == 'confirm_order') {
    $id = $_GET['id'];
    // Vì ID đơn hàng là chuỗi (DH...), cần để trong dấu nháy
    $conn->query("UPDATE orders SET status = 1 WHERE id='$id'");
    header("Location: ../admin.php");
}

$conn->close();
?>