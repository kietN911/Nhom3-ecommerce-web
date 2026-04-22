<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\CustomerAddress;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

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
                'email' => 'admin@fkstore.vn',
                'password' => '123456',
                'avatar' => 'https://images.unsplash.com/photo-1544723795-3fb6469f5b39?auto=format&fit=crop&w=400&q=80',
                'default_address' => '12 Nguyen Hue, Ben Nghe, Quan 1, TP. Ho Chi Minh',
                'status' => 1,
                'user_type' => 1,
            ]
        );

        User::query()->updateOrCreate(
            ['phone' => '0912345678'],
            [
                'fullname' => 'Khách hàng mẫu',
                'email' => 'khachhang@fkstore.vn',
                'password' => '123456',
                'avatar' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=400&q=80',
                'default_address' => '25 Le Loi, Ward 1, Go Vap, TP. Ho Chi Minh',
                'status' => 1,
                'user_type' => 0,
            ]
        );

        $categories = [
            ['name' => 'Điện tử', 'description' => 'Thiết bị công nghệ, âm thanh và phụ kiện thông minh.', 'sort_order' => 1],
            ['name' => 'Thời trang', 'description' => 'Trang phục và phụ kiện theo xu hướng hiện đại.', 'sort_order' => 2],
            ['name' => 'Gia dụng', 'description' => 'Sản phẩm thiết yếu cho không gian sống tiện nghi.', 'sort_order' => 3],
            ['name' => 'Làm đẹp', 'description' => 'Thiết bị và sản phẩm chăm sóc cá nhân chất lượng.', 'sort_order' => 4],
            ['name' => 'Phụ kiện', 'description' => 'Balo, túi xách và đồ dùng hỗ trợ công việc hằng ngày.', 'sort_order' => 5],
            ['name' => 'Sách & Văn phòng', 'description' => 'Sổ tay, dụng cụ học tập và văn phòng phẩm.', 'sort_order' => 6],
        ];

        foreach ($categories as $categoryData) {
            Category::query()->updateOrCreate(
                ['slug' => Str::slug($categoryData['name'])],
                $categoryData + ['status' => 1, 'image' => null]
            );
        }

        $products = [
            [
                'title' => 'Tai nghe Bluetooth Pro X5',
                'category' => 'Điện tử',
                'price' => 890000,
                'original_price' => 990000,
                'sale_price' => 890000,
                'description' => 'Tai nghe không dây chống ồn, pin dùng đến 30 giờ, phù hợp làm việc và giải trí.',
                'short_description' => 'Tai nghe chống ồn chủ động, pin bền và kết nối ổn định.',
                'brand' => 'SoundMax',
                'stock_quantity' => 45,
                'is_featured' => 1,
                'tags' => ['audio', 'bluetooth', 'work'],
                'img' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=900&q=80',
            ],
            [
                'title' => 'Đồng hồ thông minh Active S2',
                'category' => 'Điện tử',
                'price' => 1590000,
                'original_price' => 1790000,
                'sale_price' => 1590000,
                'description' => 'Theo dõi sức khỏe, nhận thông báo nhanh và thiết kế trẻ trung cho phong cách năng động.',
                'short_description' => 'Smartwatch theo dõi sức khỏe và vận động hằng ngày.',
                'brand' => 'Active',
                'stock_quantity' => 32,
                'is_featured' => 1,
                'tags' => ['smartwatch', 'fitness'],
                'img' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=900&q=80',
            ],
            [
                'title' => 'Áo khoác denim urban',
                'category' => 'Thời trang',
                'price' => 620000,
                'original_price' => 720000,
                'sale_price' => 620000,
                'description' => 'Form unisex dễ phối đồ, chất vải đứng dáng, phù hợp đi học và đi chơi.',
                'short_description' => 'Áo khoác denim unisex phong cách trẻ trung.',
                'brand' => 'Urban',
                'stock_quantity' => 25,
                'is_featured' => 1,
                'tags' => ['fashion', 'denim', 'unisex'],
                'img' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?auto=format&fit=crop&w=900&q=80',
            ],
            [
                'title' => 'Bình giữ nhiệt inox 1L',
                'category' => 'Gia dụng',
                'price' => 280000,
                'original_price' => 320000,
                'sale_price' => 280000,
                'description' => 'Giữ nóng lạnh bền lâu, nắp chống rò rỉ, thích hợp mang đi học, đi làm hoặc du lịch.',
                'short_description' => 'Bình giữ nhiệt dung tích lớn, thiết kế kín và bền.',
                'brand' => 'HomeEase',
                'stock_quantity' => 60,
                'is_featured' => 0,
                'tags' => ['home', 'travel'],
                'img' => 'https://images.unsplash.com/photo-1602143407151-7111542de6e8?auto=format&fit=crop&w=900&q=80',
            ],
            [
                'title' => 'Máy sấy tóc ion care',
                'category' => 'Làm đẹp',
                'price' => 540000,
                'original_price' => 620000,
                'sale_price' => 540000,
                'description' => 'Công suất mạnh, nhiều chế độ sấy và hỗ trợ giảm khô xơ cho tóc.',
                'short_description' => 'Máy sấy tóc ion công suất mạnh, nhiều chế độ nhiệt.',
                'brand' => 'BeautyPlus',
                'stock_quantity' => 21,
                'is_featured' => 1,
                'tags' => ['beauty', 'haircare'],
                'img' => 'https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?auto=format&fit=crop&w=900&q=80',
            ],
            [
                'title' => 'Balo laptop chống nước',
                'category' => 'Phụ kiện',
                'price' => 470000,
                'original_price' => 550000,
                'sale_price' => 470000,
                'description' => 'Ngăn chứa rộng rãi, bảo vệ laptop 15.6 inch, kiểu dáng tối giản hiện đại.',
                'short_description' => 'Balo đa năng chống nước cho laptop và đồ dùng cá nhân.',
                'brand' => 'CarryOne',
                'stock_quantity' => 34,
                'is_featured' => 0,
                'tags' => ['bag', 'office'],
                'img' => 'https://images.unsplash.com/photo-1548036328-c9fa89d128fa?auto=format&fit=crop&w=900&q=80',
            ],
            [
                'title' => 'Sổ tay planner cao cấp',
                'category' => 'Sách & Văn phòng',
                'price' => 145000,
                'original_price' => 175000,
                'sale_price' => 145000,
                'description' => 'Thiết kế tối giản, giấy dày mịn, phù hợp ghi chú công việc và kế hoạch cá nhân.',
                'short_description' => 'Sổ tay planner giấy đẹp cho công việc và học tập.',
                'brand' => 'PaperMood',
                'stock_quantity' => 80,
                'is_featured' => 0,
                'tags' => ['planner', 'office'],
                'img' => 'https://images.unsplash.com/photo-1517842645767-c639042777db?auto=format&fit=crop&w=900&q=80',
            ],
            [
                'title' => 'Đèn bàn LED cảm ứng',
                'category' => 'Gia dụng',
                'price' => 390000,
                'original_price' => 450000,
                'sale_price' => 390000,
                'description' => 'Ánh sáng dịu mắt, điều chỉnh được độ sáng, phù hợp góc học tập và làm việc.',
                'short_description' => 'Đèn bàn LED cảm ứng gọn gàng cho góc làm việc.',
                'brand' => 'BrightHome',
                'stock_quantity' => 29,
                'is_featured' => 1,
                'tags' => ['lamp', 'desk'],
                'img' => 'https://images.unsplash.com/photo-1507473885765-e6ed057f782c?auto=format&fit=crop&w=900&q=80',
            ],
        ];

        foreach ($products as $product) {
            $category = Category::query()->where('name', $product['category'])->first();

            $savedProduct = Product::query()->updateOrCreate(
                ['title' => $product['title']],
                $product + [
                    'slug' => Str::slug($product['title']),
                    'sku' => 'SKU-'.strtoupper(Str::random(8)),
                    'category_id' => $category?->id,
                    'status' => 1,
                ]
            );

            ProductImage::query()->updateOrCreate(
                [
                    'product_id' => $savedProduct->id,
                    'image_path' => $savedProduct->img,
                ],
                [
                    'is_primary' => 1,
                    'sort_order' => 1,
                ]
            );
        }

        $sampleCustomer = User::query()->where('phone', '0912345678')->first();
        if ($sampleCustomer) {
            CustomerAddress::query()->updateOrCreate(
                [
                    'user_id' => $sampleCustomer->id,
                    'label' => 'Nhà riêng',
                ],
                [
                    'receiver_name' => $sampleCustomer->fullname,
                    'receiver_phone' => $sampleCustomer->phone,
                    'address_line' => '25 Le Loi',
                    'ward' => 'Ward 1',
                    'district' => 'Go Vap',
                    'city' => 'TP. Ho Chi Minh',
                    'is_default' => 1,
                ]
            );
        }
    }
}
