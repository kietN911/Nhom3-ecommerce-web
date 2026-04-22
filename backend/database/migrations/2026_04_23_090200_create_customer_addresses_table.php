<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('customer_addresses')) {
            Schema::create('customer_addresses', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
                $table->string('receiver_name');
                $table->string('receiver_phone', 30);
                $table->string('label')->nullable();
                $table->text('address_line');
                $table->string('ward')->nullable();
                $table->string('district')->nullable();
                $table->string('city')->nullable();
                $table->tinyInteger('is_default')->default(0);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_addresses');
    }
};
