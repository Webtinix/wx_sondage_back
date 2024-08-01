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
        Schema::create('groupe_attributes', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->integer('position');
            $table->text('attr')->nullable();
            $table->string('lib')->nullable();
            $table->unsignedBigInteger('classe_id');
            $table->foreign('classe_id')->references('id')->on('classes');
            $table->unsignedBigInteger('component_id_multi');
            $table->foreign('component_id_multi')->references('id')->on('components'); 
            $table->unsignedBigInteger('component_id_unique');
            $table->foreign('component_id_unique')->references('id')->on('components');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('groupe_attributes');
    }
};
