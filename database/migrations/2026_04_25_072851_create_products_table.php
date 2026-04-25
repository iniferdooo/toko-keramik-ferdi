<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('sku')->unique();
            $table->string('name');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->decimal('price', 15, 2);
            $table->integer('stock')->default(0);
            $table->text('description');
            $table->string('size');             // contoh: 60x60, 30x60
            $table->string('motif')->nullable();
            $table->string('brand')->default('Ferdi');
            $table->string('color')->nullable();
            $table->string('finish')->nullable(); // glossy, matte
            $table->boolean('is_available')->default(true);
            $table->string('image')->nullable();  // gambar utama
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};