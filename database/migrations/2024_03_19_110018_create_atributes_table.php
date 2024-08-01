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
        Schema::create('attributes', function (Blueprint $table) {
            $table->id()->autoIncrement();

            $table->string('tech_name')->unique();

            $table->string('lib')->nullable();

            $table->integer('position')->default(1);

            $table->text('attr')->nullable();

            $table->text('attr_label');

            $table->text('render_in');
            $table->text('module_in');

            $table->text('render_out');
            $table->text('module_out');

            $table->boolean('is_lang')->default(0);
            $table->boolean('actif')->default(1);
            $table->boolean('visible')->default(1);
            $table->boolean('list_visible')->default(1);
            $table->boolean('required')->default(1);
            $table->boolean('disabled')->default(0);
            $table->boolean('is_dynamic_class_src')->default(0);


            $table->unsignedBigInteger('classe_id');
            $table->foreign('classe_id')->references('id')->on('classes');

            $table->unsignedBigInteger('groupe_attribute_id');
            $table->foreign('groupe_attribute_id')->references('id')->on('groupe_attributes');

            $table->unsignedBigInteger('classe_src_id')->nullable();
            $table->foreign('classe_src_id')->references('id')->on('classes');

            $table->unsignedBigInteger('component_id');
            $table->foreign('component_id')->references('id')->on('components');

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
        Schema::dropIfExists('atributes');
    }
};
