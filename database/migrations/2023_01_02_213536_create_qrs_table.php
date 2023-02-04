<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQrsTable extends Migration
{

    public function up()
    {
        Schema::create('qrs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('desk_id')->constrained()->cascadeOnDelete();
            $table->integer('code');
            $table->string('company_id')->index();
            $table->index(['id', 'code']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('qrs');
    }
}
