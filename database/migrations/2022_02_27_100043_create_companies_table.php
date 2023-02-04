<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->timestamps();
            $table->bigInteger('user_id')->index();
            $table->string('name');
            $table->string('officialname')->default('');
            $table->mediumText('description')->nullable();
            $table->boolean('hasDelivery')->default(false);
            $table->mediumText('deliveryTerm')->nullable();
            $table->boolean('hasPickup')->default(false);
            $table->mediumText('pickupTerm')->nullable();
            $table->boolean('hasCardPayment')->default(true);
            $table->string('image')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
    }
}
