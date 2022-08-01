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
        Schema::create('manajemen_hargas', function (Blueprint $table) {
            $table->id();
            $table->string('produk_slug');
            $table->string('slugmain');
            $table->integer('harga');
            $table->integer('is_penjualan')->nullable();
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
        Schema::dropIfExists('manajemen_hargas');
    }
};
