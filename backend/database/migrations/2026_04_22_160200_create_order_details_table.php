<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('order_details')) {
            Schema::create('order_details', function (Blueprint $table) {
                $table->id();
                $table->string('order_id');
                $table->unsignedBigInteger('product_id');
                $table->integer('quantity')->default(1);
                $table->integer('price')->default(0);
                $table->text('note')->nullable();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
