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
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Menu::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\MenuItem::class, 'parent_id')->nullable()->constrained('menu_items')->cascadeOnDelete();
            $table->nullableMorphs('linkable');
            $table->string('name');
            $table->string('url')->nullable();
            $table->string('image')->nullable();
            $table->string('incentive')->nullable();
            $table->tinyInteger('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_items');
    }
};
