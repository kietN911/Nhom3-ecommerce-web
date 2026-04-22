<?php
session_start();
require_once 'api/db_connect.php';
header("Content-Type: text/html; charset=UTF-8"); // <--- THÊM DÒNG NÀY

// Bảo mật: Chặn nếu không phải Admin
// (Bạn có thể bỏ comment dòng dưới khi chức năng Login đã hoàn thiện)
/*
if (!isset($_SESSION['current_user']) || $_SESSION['current_user']['user_type'] != 1) {
   echo "Truy cập bị từ chối!";
   exit();
}
*/

// 1. THỐNG KÊ DASHBOARD
$count_users = $conn->query("SELECT COUNT(*) as c FROM users WHERE user_type=0")->fetch_assoc()['c'];
$count_products = $conn->query("SELECT COUNT(*) as c FROM products WHERE status=1")->fetch_assoc()['c'];
$total_revenue = $conn->query("SELECT SUM(total_money) as s FROM orders WHERE status=1")->fetch_assoc()['s'] ?? 0;

// 2. LẤY DANH SÁCH (Có xử lý tìm kiếm đơn giản)
// Sản phẩm
$sql_prod = "SELECT * FROM products WHERE status=1";
if(isset($_GET['search_prod'])) {
    $k = $_GET['search_prod'];
    $sql_prod .= " AND title LIKE '%$k%'";
}
$products = $conn->query($sql_prod);

// Khách hàng
$users = $conn->query("SELECT * FROM users WHERE user_type=0");

// Đơn hàng
$orders = $conn->query("SELECT * FROM orders ORDER BY order_date DESC");

?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='./assets/img/favicon.png' rel='icon' type='image/x-icon' />
    <link rel="stylesheet" href="assets/css/admin.css">
    <link rel="stylesheet" href="./assets/css/toast-message.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="./assets/css/admin-responsive.css">
    <title>Quản lý F&K FOOD</title>
</head>

<body>
    <header class="header">
        <button class="menu-icon-btn"><div class="menu-icon"><i class="fa-regular fa-bars"></i></div></button>
    </header>
    <div class="container">
        <aside class="sidebar open">
            <div class="top-sidebar">
                <a href="#" class="channel-logo"><img src="./assets/img/favicon.png" alt="Channel Logo"></a>
                <div class="hidden-sidebar your-channel"><span>ADMIN F&K</span></div>
            </div>
            <div class="middle-sidebar">
                <ul class="sidebar-list">
                    <li class="sidebar-list-item tab-content active">
                        <a href="#" class="sidebar-link"><div class="sidebar-icon"><i class="fa-solid fa-chart-line me-2"></i></div><div class="hidden-sidebar">Tổng quan</div></a>
                    </li>
                    <li class="sidebar-list-item tab-content">
                        <a href="#" class="sidebar-link"><div class="sidebar-icon"><i class="fa-solid fa-box-open me-2"></i></div><div class="hidden-sidebar">Sản phẩm</div></a>
                    </li>
                    <li class="sidebar-list-item tab-content">
                        <a href="#" class="sidebar-link"><div class="sidebar-icon"><i class="fa-solid fa-users me-2"></i></div><div class="hidden-sidebar">Khách hàng</div></a>
                    </li>
                    <li class="sidebar-list-item tab-content">
                        <a href="#" class="sidebar-link"><div class="sidebar-icon"><i class="fa-solid fa-receipt me-2"></i></div><div class="hidden-sidebar">Đơn hàng</div></a>
                    </li>
                </ul>
            </div>
            <div class="bottom-sidebar">
                <ul class="sidebar-list">
                    <li class="sidebar-list-item user-logout">
                        <a href="index.php" class="sidebar-link"><div class="sidebar-icon"><i class="fa-solid fa-house me-2"></i></div><div class="hidden-sidebar">Trang chủ</div></a>
                    </li>
                    <li class="sidebar-list-item user-logout">
                        <a href="#" class="sidebar-link" id="logout-acc"><div class="sidebar-icon"><i class="fa-solid fa-right-from-bracket me-2"></i></div><div class="hidden-sidebar">Đăng xuất</div></a>

                        
                    </li>
                </ul>
            </div>
        </aside>
        <main class="content">
            <div class="section active">
                <h1 class="page-title">Trang quản trị F&K FOOD</h1>
                <div class="cards">
                    <div class="card-single">
                        <div class="box">
                            <h2><?php echo $count_users; ?></h2>
                            <div class="on-box">
                                <img src="assets/img/admin/s1.png" style="width: 100px;">
                                <h3>Khách hàng</h3>
                                <p>Tổng số khách hàng đã đăng ký.</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-single">
                        <div class="box">
                            <div class="on-box">
                                <img src="assets/img/admin/s2.png" style="width: 100px;">
                                <h2><?php echo $count_products; ?></h2>
                                <h3>Sản phẩm</h3>
                                <p>Tổng số món ăn đang bán.</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-single">
                        <div class="box">
                            <h2><?php echo number_format($total_revenue, 0, ',', '.'); ?>₫</h2>
                            <div class="on-box">
                                <img src="assets/img/admin/s3.png" style="width: 100px;">
                                <h3>Doanh thu</h3>
                                <p>Tổng doanh thu từ đơn hàng đã xử lý.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="section product-all">
                <div class="admin-control">
                    <div class="admin-control-center">
                        <form action="admin.php" method="GET" class="form-search">
                            <span class="search-btn"><i class="fa-light fa-magnifying-glass"></i></span>
                            <input type="text" name="search_prod" class="form-search-input" placeholder="Tìm kiếm tên món...">
                        </form>
                    </div>
                    <div class="admin-control-right">
                        <button class="btn-control-large" id="btn-add-product"><i class="fa-light fa-plus"></i> Thêm món mới</button>                  
                    </div>
                </div>
                <div id="show-product">
                    <?php while($row = $products->fetch_assoc()): ?>
                    <div class="list">
                        <div class="list-left">
                            <img src="<?php echo $row['img']; ?>" alt="">
                            <div class="list-info">
                                <h4><?php echo $row['title']; ?></h4>
                                <p class="list-note"><?php echo $row['description']; ?></p>
                                <span class="list-category"><?php echo $row['category']; ?></span>
                            </div>
                        </div>
                        <div class="list-right">
                            <div class="list-price"><span class="list-current-price"><?php echo number_format($row['price'], 0, ',', '.'); ?>₫</span></div>
                            <div class="list-control">
                                <div class="list-tool">
                                    <button class="btn-edit" onclick='editProduct(<?php echo json_encode($row); ?>)'><i class="fa-solid fa-pen-to-square"></i></button>
                                    <a href="api/admin_actions.php?action=delete_product&id=<?php echo $row['id']; ?>" onclick="return confirm('Bạn chắc chắn muốn xóa?')">
                                        <button class="btn-delete"><i class="fa-solid fa-trash"></i></button>
                                    </a>
                                </div>                       
                            </div>
                        </div> 
                    </div>
                    <?php endwhile; ?>
                </div>
            </div>

            <div class="section">
                <div class="table">
                    <table width="100%">
                        <thead>
                            <tr>
                                <td>ID</td>
                                <td>Họ và tên</td>
                                <td>Số điện thoại</td>
                                <td>Ngày tham gia</td>
                                <td>Trạng thái</td>
                                <td>Hành động</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($u = $users->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $u['id']; ?></td>
                                <td><?php echo $u['fullname']; ?></td>
                                <td><?php echo $u['phone']; ?></td>
                                <td><?php echo $u['created_at']; ?></td>
                                <td>
                                    <?php echo ($u['status'] == 1) ? '<span class="status-complete">Hoạt động</span>' : '<span class="status-no-complete">Bị khóa</span>'; ?>
                                </td>
                                <td>
                                    <a href="api/admin_actions.php?action=toggle_user&id=<?php echo $u['id']; ?>&status=<?php echo $u['status']; ?>">
                                        <button class="btn-delete"><i class="fa-regular fa-lock"></i> <?php echo ($u['status'] == 1) ? 'Khóa' : 'Mở'; ?></button>
                                    </a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="section">
                <div class="table">
                    <table width="100%">
                        <thead>
                            <tr>
                                <td>Mã đơn</td>
                                <td>Khách hàng</td>
                                <td>Ngày đặt</td>
                                <td>Tổng tiền</td>
                                <td>Trạng thái</td>
                                <td>Thao tác</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($o = $orders->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $o['id']; ?></td>
                                <td><?php echo $o['fullname']; ?> <br> <small><?php echo $o['phone']; ?></small></td>
                                <td><?php echo $o['order_date']; ?></td>
                                <td><?php echo number_format($o['total_money'], 0, ',', '.'); ?>₫</td>
                                <td>
                                    <?php echo ($o['status'] == 1) ? '<span class="status-complete">Đã xử lý</span>' : '<span class="status-no-complete">Chưa xử lý</span>'; ?>
                                </td>
                                <td>
                                    <?php if($o['status'] == 0): ?>
                                    <a href="api/admin_actions.php?action=confirm_order&id=<?php echo $o['id']; ?>">
                                        <button class="btn-detail">Duyệt đơn</button>
                                    </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <div class="modal add-product">
        <div class="modal-container">
            <h3 class="modal-container-title">THÔNG TIN SẢN PHẨM</h3>
            <button class="modal-close product-form"><i class="fa-regular fa-xmark"></i></button>
            <div class="modal-content">
                <form action="api/admin_actions.php?action=save_product" method="POST" enctype="multipart/form-data" class="add-product-form">
                    <input type="hidden" id="prod-id" name="id">
                    <input type="hidden" id="current-img" name="current_img">
                    <div class="modal-content-left">
                        <img src="./assets/img/blank-image.png" alt="" class="upload-image-preview" id="preview-img">
                        <div class="form-group file">
                            <label for="up-hinh-anh" class="form-label-file"><i class="fa-regular fa-cloud-arrow-up"></i>Chọn hình ảnh</label>
                            <input accept="image/jpeg, image/png, image/jpg" id="up-hinh-anh" name="up-hinh-anh" type="file" class="form-control" onchange="uploadImage(this)">
                        </div>
                    </div>
                    <div class="modal-content-right">
                        <div class="form-group">
                            <label class="form-label">Tên món</label>
                            <input id="ten-mon" name="ten-mon" type="text" placeholder="Nhập tên món" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Danh mục</label>
                            <select name="category" id="chon-mon">
                                <option>Món chay</option>
                                <option>Món mặn</option>
                                <option>Món lẩu</option>
                                <option>Món ăn vặt</option>
                                <option>Món tráng miệng</option>
                                <option>Nước uống</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Giá bán</label>
                            <input id="gia-moi" name="gia-moi" type="number" placeholder="Nhập giá bán" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Mô tả</label>
                            <textarea class="product-desc" id="mo-ta" name="mo-ta" placeholder="Nhập mô tả..."></textarea>
                        </div>
                        <button class="form-submit" type="submit"><i class="fa-regular fa-floppy-disk"></i> LƯU SẢN PHẨM</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="toast"></div>
    <script>
        // Sidebar toggle
        document.querySelector(".menu-icon-btn").addEventListener("click", () => {
            document.querySelector(".sidebar").classList.toggle("open");
        });

        // Tab switching
        const sidebars = document.querySelectorAll(".sidebar-list-item.tab-content");
        const sections = document.querySelectorAll(".section");
        for(let i = 0; i < sidebars.length; i++) {
            sidebars[i].onclick = function () {
                document.querySelector(".sidebar-list-item.active").classList.remove("active");
                document.querySelector(".section.active").classList.remove("active");
                sidebars[i].classList.add("active");
                sections[i].classList.add("active");
            };
        }

        // Modal Logic
        const modal = document.querySelector(".add-product");
        const closeBtn = document.querySelector(".modal-close");
        
        document.getElementById("btn-add-product").onclick = () => {
            // Reset form
            document.getElementById("prod-id").value = "";
            document.getElementById("ten-mon").value = "";
            document.getElementById("gia-moi").value = "";
            document.getElementById("mo-ta").value = "";
            document.getElementById("preview-img").src = "./assets/img/blank-image.png";
            modal.classList.add("open");
        }

        closeBtn.onclick = () => modal.classList.remove("open");

        function editProduct(prod) {
            document.getElementById("prod-id").value = prod.id;
            document.getElementById("ten-mon").value = prod.title;
            document.getElementById("gia-moi").value = prod.price;
            document.getElementById("mo-ta").value = prod.description;
            document.getElementById("chon-mon").value = prod.category;
            document.getElementById("preview-img").src = prod.img;
            document.getElementById("current-img").value = prod.img;
            modal.classList.add("open");
        }

        function uploadImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById('preview-img').src = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>
</html>