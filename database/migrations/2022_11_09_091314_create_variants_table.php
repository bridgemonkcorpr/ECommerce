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
        Schema::create('variants', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Product::class)->constrained()->cascadeOnDelete();
            $table->string('sku')->unique()->nullable();
            $table->string('barcode')->unique()->nullable();
            $table->decimal('price', 12)->default(0);
            $table->decimal('compare_price', 12)->default(0);
            $table->decimal('cost_price', 12)->default(0);
            $table->boolean('stock_tracking')->default(true);
            $table->integer('stock_value')->default(0);
            $table->enum('shipping_type', ['physical', 'digital'])->default('physical');
            $table->decimal('weight_value', 10, 4)->default(0);
            $table->enum('weight_unit', ['lb', 'oz', 'kg', 'g'])->default('kg');
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
        Schema::dropIfExists('variants');
    }
};
