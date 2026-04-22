<?php
session_start();
require_once 'api/db_connect.php';
header("Content-Type: text/html; charset=UTF-8");

// --- 1. XỬ LÝ LỌC & TÌM KIẾM ---
$where_clause = "WHERE status = 1"; 

if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = $conn->real_escape_string($_GET['search']);
    $where_clause .= " AND title LIKE '%$search%'";
}

if (isset($_GET['category']) && !empty($_GET['category']) && $_GET['category'] != 'Tất cả') {
    $cate = $conn->real_escape_string($_GET['category']);
    $where_clause .= " AND category = '$cate'";
}

if (isset($_GET['min_price']) && isset($_GET['max_price'])) {
    $min = (int)$_GET['min_price'];
    $max = (int)$_GET['max_price'];
    if($max > 0) {
        $where_clause .= " AND price BETWEEN $min AND $max";
    }
}

// --- 2. XỬ LÝ PHÂN TRANG ---
$limit = 12; 
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $limit;

// Đếm tổng số
$sql_count = "SELECT COUNT(*) as total FROM products $where_clause";
$result_count = $conn->query($sql_count);
$row_count = $result_count->fetch_assoc();
$total_records = $row_count['total'];
$total_pages = ceil($total_records / $limit);

// Lấy dữ liệu phân trang
$sql = "SELECT * FROM products $where_clause ORDER BY id DESC LIMIT $offset, $limit";
$result = $conn->query($sql);
?> 
<!DOCTYPE html>
<html lang="vi">
...

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>F&K FOOD - Trang chủ</title>
    <link href='./assets/img/favicon.png' rel='icon' type='image/x-icon' />
    <link rel="stylesheet" href="./assets/css/main.css">
    <link rel="stylesheet" href="./assets/css/home-responsive.css">
    <link rel="stylesheet" href="./assets/css/toast-message.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>
<body>
    <header>
        <div class="header-middle">
            <div class="container">
                <div class="header-middle-left">
                    <div class="header-logo">
                        <a href="index.php">
                            <h1 style="color: #B5292F; font-weight: 800; font-size: 30px;">F&K FOOD</h1>
                        </a>
                    </div>
                </div>
                <div class="header-middle-center">
                    <form action="index.php" method="GET" class="form-search">
                        <span class="search-btn"><i class="fa-solid fa-magnifying-glass"></i></span>
                        <input type="text" name="search" class="form-search-input" placeholder="Tìm kiếm món ăn..." 
                               value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                        <button class="filter-btn"><i class="fa-light fa-filter-list"></i><span>Lọc</span></button>
                    </form>
                </div>
                <div class="header-middle-right">
                    <ul class="header-middle-right-list">
                        <li class="header-middle-right-item dropdown open">
                            <i class="fa-solid fa-user"></i>
                            <div class="auth-container">
                                <span class="text-dndk">Đăng nhập / Đăng ký</span>
                                <span class="text-tk">Tài khoản <i class="fa-sharp fa-solid fa-caret-down"></i></span>
                            </div>
                            <ul class="header-middle-right-menu">
                                <li><a id="login" href="javascript:;"><i class="fa-solid fa-right-to-bracket me-2"></i> Đăng nhập</a></li>
                                <li><a id="signup" href="javascript:;"><i class="fa-solid fa-user-plus me-2"></i> Đăng ký</a></li>
                            </ul>
                        </li>
                        <li class="header-middle-right-item open" onclick="openCart()">
                            <div class="cart-icon-menu">
                                <i class="fa-solid fa-cart-shopping"></i>
                                <span class="count-product-cart">0</span>
                            </div>
                            <span>Giỏ hàng</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </header>

    <nav class="header-bottom">
        <div class="container">
            <ul class="menu-list">
                <li class="menu-list-item"><a href="index.php" class="menu-link">Trang chủ</a></li>
                <?php 
                $cats = ['Món chay', 'Món mặn', 'Món lẩu', 'Món ăn vặt', 'Món tráng miệng', 'Nước uống'];
                foreach($cats as $cat): 
                ?>
                    <li class="menu-list-item">
                        <a href="index.php?category=<?php echo urlencode($cat); ?>" class="menu-link"><?php echo $cat; ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </nav>

    <div class="advanced-search">
        <div class="container">
            <form action="index.php" method="GET" style="display:flex; align-items:center; width:100%">
                <div class="advanced-search-category">
                    <span>Phân loại </span>
                    <select name="category" id="advanced-search-category-select">
                        <option value="Tất cả">Tất cả</option>
                        <option value="Món mặn">Món mặn</option>
                        <option value="Món chay">Món chay</option>
                        <option value="Món lẩu">Món lẩu</option>
                        <option value="Nước uống">Nước uống</option>
                    </select>
                </div>
                <div class="advanced-search-price">
                    <span>Giá từ</span>
                    <input type="number" name="min_price" placeholder="tối thiểu" id="min-price">
                    <span>đến</span>
                    <input type="number" name="max_price" placeholder="tối đa" id="max-price">
                    <button id="advanced-search-price-btn" type="submit"><i class="fa-light fa-magnifying-glass-dollar"></i></button>
                </div>
                <div class="advanced-search-control">
                    <a href="index.php"><button type="button" id="reset-search"><i class="fa-light fa-arrow-rotate-right"></i></button></a>
                    <button type="button" onclick="closeSearchAdvanced()"><i class="fa-light fa-xmark"></i></button>
                </div>
            </form>
        </div>
    </div>

    <main class="main-wrapper">
        <div class="container" id="trangchu">
            <div class="home-slider">
                <img src="./assets/img/banner-1.png" alt="F&K FOOD Banner">
            </div>
            
            <div class="home-title-block" id="home-title">
                <h2 class="home-title">Thực đơn F&K FOOD</h2>
            </div>

           <div class="home-products" id="home-products">
                <?php 
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()): 
                ?>
                    <div class="col-product">
                        <article class="card-product">
                            <div class="card-header">
                                <a href="javascript:;" class="card-image-link" onclick="detailProductPHP(<?php echo htmlspecialchars(json_encode($row)); ?>)">
                                    <img class="card-image" src="<?php echo $row['img']; ?>" alt="<?php echo $row['title']; ?>" onerror="this.src='./assets/img/products/nam-dui-ga-chay-toi.jpeg'">
                                </a>
                            </div>
                            <div class="food-info">
                                <div class="card-content">
                                    <div class="card-title">
                                        <a href="javascript:;" class="card-title-link" onclick="detailProductPHP(<?php echo htmlspecialchars(json_encode($row)); ?>)"><?php echo $row['title']; ?></a>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="product-price">
                                        <span class="current-price"><?php echo number_format($row['price'], 0, ',', '.'); ?>₫</span>
                                    </div>
                                    <div class="product-buy">
                                        <button onclick='detailProductPHP(<?php echo json_encode($row); ?>)' class="card-button order-item"><i class="fa-regular fa-cart-shopping-fast"></i> Đặt món</button>
                                    </div> 
                                </div>
                            </div>
                        </article>
                    </div>
                <?php 
                    endwhile; 
                } else {
                    echo '<div class="no-result"><div class="no-result-i"><i class="fa-light fa-face-sad-cry"></i></div><div class="no-result-h">Không tìm thấy món nào!</div></div>';
                }
                ?>
            </div>

            <div class="page-nav">
                <ul class="page-nav-list">
                    <?php 
                    // Hàm giữ lại các tham số lọc cũ (category, search...) khi chuyển trang
                    function buildUrl($newPage) {
                        $params = $_GET; 
                        $params['page'] = $newPage;
                        return '?' . http_build_query($params);
                    }

                    // Nút Lùi (Prev)
                    if($page > 1): ?>
                        <li class="page-nav-item">
                            <a href="<?php echo buildUrl($page - 1); ?>"><i class="fa-solid fa-chevron-left"></i></a>
                        </li>
                    <?php endif; ?>

                    <?php 
                    // Vòng lặp hiển thị số trang (1, 2, 3...)
                    for($i = 1; $i <= $total_pages; $i++): 
                    ?>
                        <li class="page-nav-item <?php if($i == $page) echo 'active'; ?>">
                            <a href="<?php echo buildUrl($i); ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>

                    <?php 
                    // Nút Tiến (Next)
                    if($page < $total_pages): ?>
                        <li class="page-nav-item">
                            <a href="<?php echo buildUrl($page + 1); ?>"><i class="fa-solid fa-chevron-right"></i></a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
        
        <div class="container" id="account-user">... (Giữ nguyên code cũ) ...</div>
        <div class="container" id="order-history">... (Giữ nguyên code cũ) ...</div>
    </main>

    <div class="modal product-detail">
        <button class="modal-close close-popup"><i class="fa-thin fa-xmark"></i></button>
        <div class="modal-container mdl-cnt" id="product-detail-content">
            </div>
    </div>

    <div class="modal product-detail">
    <button class="modal-close close-popup"><i class="fa-thin fa-xmark"></i></button>
    <div class="modal-container mdl-cnt" id="product-detail-content">
    </div>
</div>

<div class="modal signup-login">
    <div class="modal-container">
        <button class="form-close" onclick="closeModal()"><i class="fa-solid fa-xmark"></i></button>
        <div class="forms mdl-cnt">
            <div class="form-content sign-up">
                <h3 class="form-title">Đăng ký tài khoản</h3>
                <p class="form-description">Đăng ký thành viên để mua hàng và nhận những ưu đãi đặc biệt từ chúng tôi</p>
                <form action="" class="signup-form">
                    <div class="form-group">
                        <label for="fullname" class="form-label">Tên đầy đủ</label>
                        <input id="fullname" name="fullname" type="text" placeholder="VD: Nhật Sinh" class="form-control">
                        <span class="form-message-name form-message"></span>
                    </div>
                    <div class="form-group">
                        <label for="phone" class="form-label">Số điện thoại</label>
                        <input id="phone" name="phone" type="text" placeholder="Nhập số điện thoại" class="form-control">
                        <span class="form-message-phone form-message"></span>
                    </div>
                    <div class="form-group">
                        <label for="password" class="form-label">Mật khẩu</label>
                        <input id="password" name="password" type="password" placeholder="Nhập mật khẩu" class="form-control">
                        <span class="form-message-password form-message"></span>
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">Nhập lại mật khẩu</label>
                        <input id="password_confirmation" name="password_confirmation" placeholder="Nhập lại mật khẩu" type="password" class="form-control">
                        <span class="form-message-password-confi form-message"></span>
                    </div>
                    <div class="form-group">
                        <input class="checkbox" name="checkbox" required="" type="checkbox" id="checkbox-signup">
                        <label for="checkbox-signup" class="form-checkbox">Tôi đồng ý với <a href="#" title="chính sách trang web" target="_blank">chính sách trang web</a></label>
                        <p class="form-message-checkbox form-message"></p>
                    </div>
                    <button class="form-submit" id="signup-button">Đăng ký</button>
                </form>
                <p class="change-login">Bạn đã có tài khoản ? <a href="javascript:;" class="login-link">Đăng nhập ngay</a></p>
            </div>
            <div class="form-content login">
                <h3 class="form-title">Đăng nhập tài khoản</h3>
                <p class="form-description">Đăng nhập thành viên để mua hàng và nhận những ưu đãi đặc biệt từ chúng tôi</p>
                <form action="" class="login-form">
                    <div class="form-group">
                        <label for="phone" class="form-label">Số điện thoại</label>
                        <input id="phone-login" name="phone" type="text" placeholder="Nhập số điện thoại" class="form-control">
                        <span class="form-message phonelog"></span>
                    </div>
                    <div class="form-group">
                        <label for="password" class="form-label">Mật khẩu</label>
                        <input id="password-login" name="password" type="password" placeholder="Nhập mật khẩu" class="form-control">
                        <span class="form-message-check-login form-message"></span>
                    </div>
                    <button class="form-submit" id="login-button">Đăng nhập</button>
                </form>
                <p class="change-login">Bạn chưa có tài khoản ? <a href="javascript:;" class="signup-link">Đăng kí ngay</a></p>
            </div>
        </div>
    </div>
</div>

<div class="modal-cart">
    <div class="cart-container">
        <div class="cart-header">
            <h3 class="cart-header-title"><i class="fa-regular fa-basket-shopping-simple"></i> Giỏ hàng</h3>
            <button class="cart-close" onclick="closeCart()"><i class="fa-sharp fa-solid fa-xmark"></i></button>
        </div>
        <div class="cart-body">
            <div class="gio-hang-trong">
                <i class="fa-thin fa-cart-xmark"></i>
                <p>Không có sản phẩm nào trong giỏ hàng của bạn</p>
            </div>
            <ul class="cart-list">
            </ul>
        </div>
        <div class="cart-footer">
            <div class="cart-total-price">
                <p class="text-tt">Tổng tiền:</p>
                <p class="text-price">0đ</p>
            </div>
            <div class="cart-footer-payment">
                <button class="them-mon"><i class="fa-regular fa-plus"></i> Thêm món</button>
                <button class="thanh-toan disabled">Thanh toán</button>
            </div>
        </div>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <div class="footer-top">
            <div class="footer-top-content">
                <div class="footer-top-img">
                    <a href="index.php"><h1 style="color: #B5292F;">F&K FOOD</h1></a>
                </div>
                <div class="footer-top-subbox">
                    <div class="footer-top-subs">
                        <h2 class="footer-top-subs-title">Đăng ký nhận tin</h2>
                        <p class="footer-top-subs-text">Nhận thông tin mới nhất từ chúng tôi</p>
                    </div>
                    <form class="form-ground">
                        <input type="email" class="form-ground-input" placeholder="Nhập email của bạn">
                        <button class="form-ground-btn">
                            <span>ĐĂNG KÝ</span>
                            <i class="fa-solid fa-arrow-right"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="widget-area">
        <div class="container">
            <div class="widget-row">
                <div class="widget-row-col-1">
                    <h3 class="widget-title">Về chúng tôi</h3>
                    <div class="widget-row-col-content">
                        <p>F&K FOOD là thương hiệu uy tín, cam kết chất lượng sản phẩm lên hàng đầu.</p>
                    </div>
                    <div class="widget-social">
                        <div class="widget-social-item"><a href=""><i class="fab fa-facebook-f"></i></a></div>
                        <div class="widget-social-item"><a href=""><i class="fab fa-twitter"></i></a></div>
                    </div>
                </div>
                <div class="widget-row-col">
                    <h3 class="widget-title">Liên kết</h3>
                    <ul class="widget-contact">
                        <li class="widget-contact-item"><a href=""><i class="fa-solid fa-chevron-right"></i><span>Về chúng tôi</span></a></li>
                        <li class="widget-contact-item"><a href=""><i class="fa-solid fa-chevron-right"></i><span>Thực đơn</span></a></li>
                    </ul>
                </div>
                <div class="widget-row-col-1">
                    <h3 class="widget-title">Liên hệ</h3>
                    <div class="contact">
                        <div class="contact-item">
                            <div class="contact-item-icon"><i class="fa-solid fa-location-dot"></i></div>
                            <div class="contact-content"><span>TP. Hồ Chí Minh</span></div>
                        </div>
                        <div class="contact-item">
                            <div class="contact-item-icon"><i class="fa-solid fa-phone"></i></div>
                            <div class="contact-content contact-item-phone"><span>0123 456 789</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<div class="copyright-wrap">
    <div class="container">
        <div class="copyright-content">
            <p>Copyright 2025 F&K FOOD. All Rights Reserved.</p>
        </div>
    </div>
</div>
<div class="back-to-top">
    <a href="#"><i class="fa-regular fa-arrow-up"></i></a>
</div>
    
    <div id="toast"></div>
    <script src="./js/main.js"></script>
    <script src="./js/checkout.js"></script>
    <script src="./js/toast-message.js"></script>

    <script>
        // Hàm hỗ trợ mở popup chi tiết khi PHP đã render xong
        function detailProductPHP(product) {
            // Gọi hàm detailProduct cũ trong main.js nhưng sửa lại logic một chút
            showModalDetail(product);
        }
    </script>
</body>
</html>