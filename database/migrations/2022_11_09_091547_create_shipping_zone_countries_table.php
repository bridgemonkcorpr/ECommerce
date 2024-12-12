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
        Schema::create('shipping_zone_countries', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\ShippingZone::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\Country::class)->constrained()->cascadeOnDelete();
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
        Schema::dropIfExists('shipping_zone_countries');
    }
};
