<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id()->startingValue(1001);
            $table->foreignIdFor(\App\Models\Customer::class)->nullable()->constrained()->cascadeOnDelete();
            $table->string('customer_email')->nullable();
            $table->string('customer_phone')->nullable();
            $table->string('order_status')->default(\App\Enums\OrderStatus::OPEN->name);
            $table->foreignIdFor(\App\Models\PaymentMethod::class)->constrained()->cascadeOnDelete();
            $table->string('payment_status')->default(\App\Enums\PaymentStatus::PENDING->name);
            $table->string('shipping_rate')->nullable();
            $table->decimal('shipping_price', 12)->default(0);
            $table->string('shipping_status')->default(\App\Enums\ShippingStatus::UNSHIPPED->value);
            $table->json('tax_breakdown');
            $table->json('meta')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
