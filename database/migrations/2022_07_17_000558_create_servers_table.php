<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servers', function (Blueprint $table) {
            $table->id();
            $table->string('model');
            $table->integer('ram_size')->unsigned()->default(0)->index();
            $table->string('ram_unit', 2);
            $table->string('ram_type', 10);
            $table->integer('storage_size')->unsigned()->default(0)->index();
            $table->string('storage_unit', 2);
            $table->smallInteger('storage_number')->unsigned()->default(1)->index();
            $table->integer('storage_type_id')->unsigned()->index();
            $table->integer('location_id')->unsigned()->index();
            $table->decimal('price', 10, 2, true)->default(0);
            $table->enum('currency', ['eur', 'usd'])->default('eur')->index();
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
        Schema::dropIfExists('servers');
    }
};
