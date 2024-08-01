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
        Schema::create('classes', function (Blueprint $table) {
            $table->id()->autoIncrement();

            $table->string('tech_name')->unique();
            $table->string('lib');
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies');

            $table->unsignedBigInteger('component_multi_id');
            $table->foreign('component_multi_id')->references('id')->on('components');

            $table->unsignedBigInteger('component_unique_id');
            $table->foreign('component_unique_id')->references('id')->on('components');

            $table->string('class_parent_id')->default("0");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classes');
    }
};
