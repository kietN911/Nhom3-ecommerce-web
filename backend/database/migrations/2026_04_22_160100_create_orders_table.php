<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('orders')) {
            Schema::create('orders', function (Blueprint $table) {
                $table->string('id')->primary();
                $table->foreignId('user_id')->nullable();
                $table->string('fullname');
                $table->string('phone');
                $table->text('address');
                $table->integer('total_money')->default(0);
                $table->text('note')->nullable();
                $table->string('shipping_method')->nullable();
                $table->tinyInteger('status')->default(0);
                $table->timestamp('order_date')->useCurrent();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
