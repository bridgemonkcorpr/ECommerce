<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cart_discounts', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Cart::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\CartItem::class)->nullable()->constrained()->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\Discount::class)->constrained()->cascadeOnDelete();
            $table->string('code');
            $table->enum('type', ['fixed', 'percentage', 'shipping']);
            $table->decimal('amount', 12);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_discounts');
    }
};
