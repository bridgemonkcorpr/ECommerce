<?php

use App\Models\PaymentMethod;
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
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('display_name');
            $table->string('identifier')->unique();
            $table->text('description')->nullable();
            $table->text('instructions')->nullable();
            $table->boolean('is_enabled')->default(false);
            $table->boolean('is_primary')->default(false);
            $table->boolean('is_third_party')->default(false);
            $table->json('meta')->nullable();
            $table->timestamps();
        });

        $this->populatePaymentMethods();
    }

    public function populatePaymentMethods()
    {
        $paymentMethods = [
            [
                'name' => 'Cash on Delivery',
                'display_name' => 'Cash on Delivery',
                'identifier' => 'cash_on_delivery',
                'description' => 'Pay with cash on delivery',
                'is_enabled' => true,
                'is_primary' => false,
                'is_third_party' => false,
            ], [
                'name' => 'Bank deposit',
                'display_name' => 'Bank deposit',
                'identifier' => 'bank_deposit',
                'description' => 'Pay with bank deposit',
                'is_enabled' => false,
                'is_primary' => false,
                'is_third_party' => false,
            ]
        ];

        DB::table('payment_methods')->insert($paymentMethods);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_methods');
    }
};
