<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       Schema::create('products', function (Blueprint $table) {
            $table->id();

            // If a category is deleted the product stays, it just becomes uncategorised.
            $table->foreignId('category_id')
                ->nullable()
                ->constrained('categories')
                ->nullOnDelete();

            $table->string('name');
            $table->string('slug')->unique();
            $table->decimal('price', 10, 2)->default(0);
            $table->string('tag', 100)->nullable();        // small label on the product card e.g. "Gift idea"
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_featured')->default(false); // used for "Recommended" ordering on frontend
            $table->boolean('status')->default(true);       // 1 = visible on frontend
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
