<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                if (! Schema::hasColumn('users', 'email')) {
                    $table->string('email')->nullable()->unique();
                }
                if (! Schema::hasColumn('users', 'avatar')) {
                    $table->string('avatar')->nullable();
                }
                if (! Schema::hasColumn('users', 'default_address')) {
                    $table->text('default_address')->nullable();
                }
                if (! Schema::hasColumn('users', 'last_login_at')) {
                    $table->timestamp('last_login_at')->nullable();
                }
            });
        }

        if (Schema::hasTable('products')) {
            Schema::table('products', function (Blueprint $table) {
                if (! Schema::hasColumn('products', 'slug')) {
                    $table->string('slug')->nullable()->unique();
                }
                if (! Schema::hasColumn('products', 'sku')) {
                    $table->string('sku')->nullable()->unique();
                }
                if (! Schema::hasColumn('products', 'category_id')) {
                    $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
                }
                if (! Schema::hasColumn('products', 'brand')) {
                    $table->string('brand')->nullable();
                }
                if (! Schema::hasColumn('products', 'stock_quantity')) {
                    $table->integer('stock_quantity')->default(0);
                }
                if (! Schema::hasColumn('products', 'original_price')) {
                    $table->integer('original_price')->nullable();
                }
                if (! Schema::hasColumn('products', 'sale_price')) {
                    $table->integer('sale_price')->nullable();
                }
                if (! Schema::hasColumn('products', 'short_description')) {
                    $table->string('short_description')->nullable();
                }
                if (! Schema::hasColumn('products', 'tags')) {
                    $table->json('tags')->nullable();
                }
                if (! Schema::hasColumn('products', 'is_featured')) {
                    $table->tinyInteger('is_featured')->default(0);
                }
            });
        }

        if (Schema::hasTable('orders')) {
            Schema::table('orders', function (Blueprint $table) {
                if (! Schema::hasColumn('orders', 'email')) {
                    $table->string('email')->nullable();
                }
                if (! Schema::hasColumn('orders', 'shipping_fee')) {
                    $table->integer('shipping_fee')->default(0);
                }
                if (! Schema::hasColumn('orders', 'discount_amount')) {
                    $table->integer('discount_amount')->default(0);
                }
                if (! Schema::hasColumn('orders', 'payment_method')) {
                    $table->string('payment_method')->nullable();
                }
                if (! Schema::hasColumn('orders', 'payment_status')) {
                    $table->string('payment_status')->default('pending');
                }
                if (! Schema::hasColumn('orders', 'shipping_status')) {
                    $table->string('shipping_status')->default('pending');
                }
                if (! Schema::hasColumn('orders', 'confirmed_at')) {
                    $table->timestamp('confirmed_at')->nullable();
                }
            });
        }

        if (Schema::hasTable('order_details')) {
            Schema::table('order_details', function (Blueprint $table) {
                if (! Schema::hasColumn('order_details', 'product_title')) {
                    $table->string('product_title')->nullable();
                }
                if (! Schema::hasColumn('order_details', 'product_sku')) {
                    $table->string('product_sku')->nullable();
                }
                if (! Schema::hasColumn('order_details', 'product_image')) {
                    $table->string('product_image')->nullable();
                }
                if (! Schema::hasColumn('order_details', 'subtotal')) {
                    $table->integer('subtotal')->default(0);
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('order_details')) {
            Schema::table('order_details', function (Blueprint $table) {
                foreach (['product_title', 'product_sku', 'product_image', 'subtotal'] as $column) {
                    if (Schema::hasColumn('order_details', $column)) {
                        $table->dropColumn($column);
                    }
                }
            });
        }

        if (Schema::hasTable('orders')) {
            Schema::table('orders', function (Blueprint $table) {
                foreach (['email', 'shipping_fee', 'discount_amount', 'payment_method', 'payment_status', 'shipping_status', 'confirmed_at'] as $column) {
                    if (Schema::hasColumn('orders', $column)) {
                        $table->dropColumn($column);
                    }
                }
            });
        }

        if (Schema::hasTable('products')) {
            Schema::table('products', function (Blueprint $table) {
                if (Schema::hasColumn('products', 'category_id')) {
                    $table->dropConstrainedForeignId('category_id');
                }
                foreach (['slug', 'sku', 'brand', 'stock_quantity', 'original_price', 'sale_price', 'short_description', 'tags', 'is_featured'] as $column) {
                    if (Schema::hasColumn('products', $column)) {
                        $table->dropColumn($column);
                    }
                }
            });
        }

        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                foreach (['email', 'avatar', 'default_address', 'last_login_at'] as $column) {
                    if (Schema::hasColumn('users', $column)) {
                        $table->dropColumn($column);
                    }
                }
            });
        }
    }
};
