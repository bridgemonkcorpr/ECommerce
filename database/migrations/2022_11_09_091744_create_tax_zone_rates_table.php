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
        Schema::create('tax_zone_rates', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\TaxZone::class)->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->decimal('percentage');
            $table->tinyInteger('priority')->default(1);
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
        Schema::dropIfExists('tax_zone_rates');
    }
};
