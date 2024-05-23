<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('data_langs', function (Blueprint $table) {
            $table->id()->autoIncrement();

            $table->unsignedBigInteger('lang_id');
            $table->foreign('lang_id')->references('id')->on('langs');

            $table->unsignedBigInteger('data_id');
            $table->foreign('data_id')->references('id')->on('datas');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_langs');
    }
};
