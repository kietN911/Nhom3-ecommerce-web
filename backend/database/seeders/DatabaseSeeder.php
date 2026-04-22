<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['phone' => '0987654321'],
            [
                'fullname' => 'Quản trị viên F&K Store',
                'password' => '123456',
                'status' => 1,
                'user_type' => 1,
            ]
        );

        User::query()->updateOrCreate(
            ['phone' => '0912345678'],
            [
                'fullname' => 'Khách hàng mẫu',
                'password' => '123456',
                'status' => 1,
                'user_type' => 0,
            ]
        );

        $products = [
            [
                'title' => 'Tai nghe Bluetooth Pro X5',
                'category' => 'Điện tử',
                'price' => 890000,
                'description' => 'Tai nghe không dây chống ồn, pin dùng đến 30 giờ, phù hợp làm việc và giải trí.',
                'img' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=900&q=80',
            ],
            [
                'title' => 'Đồng hồ thông minh Active S2',
                'category' => 'Điện tử',
                'price' => 1590000,
                'description' => 'Theo dõi sức khỏe, nhận thông báo nhanh và thiết kế trẻ trung cho phong cách năng động.',
                'img' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=900&q=80',
            ],
            [
                'title' => 'Áo khoác denim urban',
                'category' => 'Thời trang',
                'price' => 620000,
                'description' => 'Form unisex dễ phối đồ, chất vải đứng dáng, phù hợp đi học và đi chơi.',
                'img' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?auto=format&fit=crop&w=900&q=80',
            ],
            [
                'title' => 'Bình giữ nhiệt inox 1L',
                'category' => 'Gia dụng',
                'price' => 280000,
                'description' => 'Giữ nóng lạnh bền lâu, nắp chống rò rỉ, thích hợp mang đi học, đi làm hoặc du lịch.',
                'img' => 'https://images.unsplash.com/photo-1602143407151-7111542de6e8?auto=format&fit=crop&w=900&q=80',
            ],
            [
                'title' => 'Máy sấy tóc ion care',
                'category' => 'Làm đẹp',
                'price' => 540000,
                'description' => 'Công suất mạnh, nhiều chế độ sấy và hỗ trợ giảm khô xơ cho tóc.',
                'img' => 'https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?auto=format&fit=crop&w=900&q=80',
            ],
            [
                'title' => 'Balo laptop chống nước',
                'category' => 'Phụ kiện',
                'price' => 470000,
                'description' => 'Ngăn chứa rộng rãi, bảo vệ laptop 15.6 inch, kiểu dáng tối giản hiện đại.',
                'img' => 'https://images.unsplash.com/photo-1548036328-c9fa89d128fa?auto=format&fit=crop&w=900&q=80',
            ],
            [
                'title' => 'Sổ tay planner cao cấp',
                'category' => 'Sách & Văn phòng',
                'price' => 145000,
                'description' => 'Thiết kế tối giản, giấy dày mịn, phù hợp ghi chú công việc và kế hoạch cá nhân.',
                'img' => 'https://images.unsplash.com/photo-1517842645767-c639042777db?auto=format&fit=crop&w=900&q=80',
            ],
            [
                'title' => 'Đèn bàn LED cảm ứng',
                'category' => 'Gia dụng',
                'price' => 390000,
                'description' => 'Ánh sáng dịu mắt, điều chỉnh được độ sáng, phù hợp góc học tập và làm việc.',
                'img' => 'https://images.unsplash.com/photo-1507473885765-e6ed057f782c?auto=format&fit=crop&w=900&q=80',
            ],
        ];

        foreach ($products as $product) {
            Product::query()->updateOrCreate(
                ['title' => $product['title']],
                $product + ['status' => 1]
            );
        }
    }
}
