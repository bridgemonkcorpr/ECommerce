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
        Schema::create('shipping_zone_rates', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\ShippingZone::class)->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->decimal('price', 12)->default(0);
            $table->text('description')->nullable();
            $table->enum('based_on', ['weight', 'price'])->nullable();
            $table->decimal('min_value', 12)->nullable();
            $table->decimal('max_value', 12)->nullable();
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
        Schema::dropIfExists('shipping_zone_rates');
    }
};
