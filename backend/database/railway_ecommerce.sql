SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `order_details`;
DROP TABLE IF EXISTS `orders`;
DROP TABLE IF EXISTS `customer_addresses`;
DROP TABLE IF EXISTS `product_images`;
DROP TABLE IF EXISTS `products`;
DROP TABLE IF EXISTS `categories`;
DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `fullname` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `default_address` text,
  `status` tinyint NOT NULL DEFAULT '1',
  `user_type` tinyint NOT NULL DEFAULT '0',
  `last_login_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `remember_token` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_phone_unique` (`phone`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text,
  `image` varchar(255) DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '1',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_name_unique` (`name`),
  UNIQUE KEY `categories_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `sku` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `category_id` bigint unsigned DEFAULT NULL,
  `brand` varchar(255) DEFAULT NULL,
  `price` int NOT NULL DEFAULT '0',
  `original_price` int DEFAULT NULL,
  `sale_price` int DEFAULT NULL,
  `description` text,
  `short_description` varchar(255) DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL,
  `stock_quantity` int NOT NULL DEFAULT '0',
  `tags` json DEFAULT NULL,
  `is_featured` tinyint NOT NULL DEFAULT '0',
  `status` tinyint NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `products_slug_unique` (`slug`),
  UNIQUE KEY `products_sku_unique` (`sku`),
  KEY `products_category_id_foreign` (`category_id`),
  CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `product_images` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint unsigned NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `is_primary` tinyint NOT NULL DEFAULT '0',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `product_images_product_id_foreign` (`product_id`),
  CONSTRAINT `product_images_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `customer_addresses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `receiver_name` varchar(255) NOT NULL,
  `receiver_phone` varchar(30) NOT NULL,
  `label` varchar(255) DEFAULT NULL,
  `address_line` text NOT NULL,
  `ward` varchar(255) DEFAULT NULL,
  `district` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `is_default` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `customer_addresses_user_id_foreign` (`user_id`),
  CONSTRAINT `customer_addresses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `orders` (
  `id` varchar(50) NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `fullname` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` text NOT NULL,
  `total_money` int NOT NULL DEFAULT '0',
  `shipping_fee` int NOT NULL DEFAULT '0',
  `discount_amount` int NOT NULL DEFAULT '0',
  `note` text,
  `shipping_method` varchar(255) DEFAULT NULL,
  `payment_method` varchar(255) DEFAULT NULL,
  `payment_status` varchar(255) NOT NULL DEFAULT 'pending',
  `shipping_status` varchar(255) NOT NULL DEFAULT 'pending',
  `status` tinyint NOT NULL DEFAULT '0',
  `order_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `confirmed_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `orders_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `order_details` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` varchar(50) NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `product_title` varchar(255) DEFAULT NULL,
  `product_sku` varchar(255) DEFAULT NULL,
  `product_image` varchar(255) DEFAULT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `price` int NOT NULL DEFAULT '0',
  `subtotal` int NOT NULL DEFAULT '0',
  `note` text,
  PRIMARY KEY (`id`),
  KEY `order_details_order_id_index` (`order_id`),
  KEY `order_details_product_id_index` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`id`, `fullname`, `phone`, `email`, `password`, `avatar`, `default_address`, `status`, `user_type`, `last_login_at`) VALUES
(1, 'Quản trị viên F&K Store', '0987654321', 'admin@fkstore.vn', '123456', 'https://images.unsplash.com/photo-1544723795-3fb6469f5b39?auto=format&fit=crop&w=400&q=80', '12 Nguyen Hue, Ben Nghe, Quan 1, TP. Ho Chi Minh', 1, 1, NULL),
(2, 'Khách hàng mẫu', '0912345678', 'khachhang@fkstore.vn', '123456', 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=400&q=80', '25 Le Loi, Ward 1, Go Vap, TP. Ho Chi Minh', 1, 0, NULL);

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `image`, `status`, `sort_order`) VALUES
(1, 'Điện tử', 'dien-tu', 'Thiết bị công nghệ, âm thanh và phụ kiện thông minh.', NULL, 1, 1),
(2, 'Thời trang', 'thoi-trang', 'Trang phục và phụ kiện theo xu hướng hiện đại.', NULL, 1, 2),
(3, 'Gia dụng', 'gia-dung', 'Sản phẩm thiết yếu cho không gian sống tiện nghi.', NULL, 1, 3),
(4, 'Làm đẹp', 'lam-dep', 'Thiết bị và sản phẩm chăm sóc cá nhân chất lượng.', NULL, 1, 4),
(5, 'Phụ kiện', 'phu-kien', 'Balo, túi xách và đồ dùng hỗ trợ công việc hằng ngày.', NULL, 1, 5),
(6, 'Sách & Văn phòng', 'sach-van-phong', 'Sổ tay, dụng cụ học tập và văn phòng phẩm.', NULL, 1, 6);

INSERT INTO `products` (`id`, `title`, `slug`, `sku`, `category`, `category_id`, `brand`, `price`, `original_price`, `sale_price`, `description`, `short_description`, `img`, `stock_quantity`, `tags`, `is_featured`, `status`) VALUES
(1, 'Tai nghe Bluetooth Pro X5', 'tai-nghe-bluetooth-pro-x5', 'SKU-AUDIO001', 'Điện tử', 1, 'SoundMax', 890000, 990000, 890000, 'Tai nghe không dây chống ồn, pin dùng đến 30 giờ, phù hợp làm việc và giải trí.', 'Tai nghe chống ồn chủ động, pin bền và kết nối ổn định.', 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=900&q=80', 45, JSON_ARRAY('audio', 'bluetooth', 'work'), 1, 1),
(2, 'Đồng hồ thông minh Active S2', 'dong-ho-thong-minh-active-s2', 'SKU-WATCH002', 'Điện tử', 1, 'Active', 1590000, 1790000, 1590000, 'Theo dõi sức khỏe, nhận thông báo nhanh và thiết kế trẻ trung cho phong cách năng động.', 'Smartwatch theo dõi sức khỏe và vận động hằng ngày.', 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=900&q=80', 32, JSON_ARRAY('smartwatch', 'fitness'), 1, 1),
(3, 'Áo khoác denim urban', 'ao-khoac-denim-urban', 'SKU-FASHION003', 'Thời trang', 2, 'Urban', 620000, 720000, 620000, 'Form unisex dễ phối đồ, chất vải đứng dáng, phù hợp đi học và đi chơi.', 'Áo khoác denim unisex phong cách trẻ trung.', 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?auto=format&fit=crop&w=900&q=80', 25, JSON_ARRAY('fashion', 'denim', 'unisex'), 1, 1),
(4, 'Bình giữ nhiệt inox 1L', 'binh-giu-nhiet-inox-1l', 'SKU-HOME004', 'Gia dụng', 3, 'HomeEase', 280000, 320000, 280000, 'Giữ nóng lạnh bền lâu, nắp chống rò rỉ, thích hợp mang đi học, đi làm hoặc du lịch.', 'Bình giữ nhiệt dung tích lớn, thiết kế kín và bền.', 'https://images.unsplash.com/photo-1602143407151-7111542de6e8?auto=format&fit=crop&w=900&q=80', 60, JSON_ARRAY('home', 'travel'), 0, 1),
(5, 'Máy sấy tóc ion care', 'may-say-toc-ion-care', 'SKU-BEAUTY005', 'Làm đẹp', 4, 'BeautyPlus', 540000, 620000, 540000, 'Công suất mạnh, nhiều chế độ sấy và hỗ trợ giảm khô xơ cho tóc.', 'Máy sấy tóc ion công suất mạnh, nhiều chế độ nhiệt.', 'https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?auto=format&fit=crop&w=900&q=80', 21, JSON_ARRAY('beauty', 'haircare'), 1, 1),
(6, 'Balo laptop chống nước', 'balo-laptop-chong-nuoc', 'SKU-BAG006', 'Phụ kiện', 5, 'CarryOne', 470000, 550000, 470000, 'Ngăn chứa rộng rãi, bảo vệ laptop 15.6 inch, kiểu dáng tối giản hiện đại.', 'Balo đa năng chống nước cho laptop và đồ dùng cá nhân.', 'https://images.unsplash.com/photo-1548036328-c9fa89d128fa?auto=format&fit=crop&w=900&q=80', 34, JSON_ARRAY('bag', 'office'), 0, 1),
(7, 'Sổ tay planner cao cấp', 'so-tay-planner-cao-cap', 'SKU-OFFICE007', 'Sách & Văn phòng', 6, 'PaperMood', 145000, 175000, 145000, 'Thiết kế tối giản, giấy dày mịn, phù hợp ghi chú công việc và kế hoạch cá nhân.', 'Sổ tay planner giấy đẹp cho công việc và học tập.', 'https://images.unsplash.com/photo-1517842645767-c639042777db?auto=format&fit=crop&w=900&q=80', 80, JSON_ARRAY('planner', 'office'), 0, 1),
(8, 'Đèn bàn LED cảm ứng', 'den-ban-led-cam-ung', 'SKU-HOME008', 'Gia dụng', 3, 'BrightHome', 390000, 450000, 390000, 'Ánh sáng dịu mắt, điều chỉnh được độ sáng, phù hợp góc học tập và làm việc.', 'Đèn bàn LED cảm ứng gọn gàng cho góc làm việc.', 'https://images.unsplash.com/photo-1507473885765-e6ed057f782c?auto=format&fit=crop&w=900&q=80', 29, JSON_ARRAY('lamp', 'desk'), 1, 1);

INSERT INTO `product_images` (`id`, `product_id`, `image_path`, `is_primary`, `sort_order`) VALUES
(1, 1, 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=900&q=80', 1, 1),
(2, 2, 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=900&q=80', 1, 1),
(3, 3, 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?auto=format&fit=crop&w=900&q=80', 1, 1),
(4, 4, 'https://images.unsplash.com/photo-1602143407151-7111542de6e8?auto=format&fit=crop&w=900&q=80', 1, 1),
(5, 5, 'https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?auto=format&fit=crop&w=900&q=80', 1, 1),
(6, 6, 'https://images.unsplash.com/photo-1548036328-c9fa89d128fa?auto=format&fit=crop&w=900&q=80', 1, 1),
(7, 7, 'https://images.unsplash.com/photo-1517842645767-c639042777db?auto=format&fit=crop&w=900&q=80', 1, 1),
(8, 8, 'https://images.unsplash.com/photo-1507473885765-e6ed057f782c?auto=format&fit=crop&w=900&q=80', 1, 1);

INSERT INTO `customer_addresses` (`id`, `user_id`, `receiver_name`, `receiver_phone`, `label`, `address_line`, `ward`, `district`, `city`, `is_default`) VALUES
(1, 2, 'Khách hàng mẫu', '0912345678', 'Nhà riêng', '25 Le Loi', 'Ward 1', 'Go Vap', 'TP. Ho Chi Minh', 1);

SET FOREIGN_KEY_CHECKS = 1;
