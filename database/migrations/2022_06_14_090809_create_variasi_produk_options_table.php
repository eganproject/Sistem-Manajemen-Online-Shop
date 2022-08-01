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
        Schema::create('variasi_produk_options', function (Blueprint $table) {
            $table->id();
            $table->string('namavariasioption');
            $table->string('variasi_produk_slug');
            $table->string('produk_stok_slug')->unique();
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
        Schema::dropIfExists('variasi_produk_options');
    }
};
