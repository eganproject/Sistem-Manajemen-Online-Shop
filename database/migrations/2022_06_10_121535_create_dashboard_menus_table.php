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
        Schema::create('dashboard_menus', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('url');
            $table->string('icon');
            $table->string('slugmenu')->unique();
            $table->string('is_submenu')->nullable();
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
        Schema::dropIfExists('dashboard_menus');
    }
};
