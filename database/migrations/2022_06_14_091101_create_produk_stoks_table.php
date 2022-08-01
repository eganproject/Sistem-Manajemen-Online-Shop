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
        Schema::create('produk_stoks', function (Blueprint $table) {
            $table->id();
            $table->string('stokslug')->unique();
            $table->integer('stok')->nullable();
            $table->integer('hargapokok');
            $table->integer('totalhargapokok');
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
        Schema::dropIfExists('produk_stoks');
    }
};
