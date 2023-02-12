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
        Schema::create('sentences', function (Blueprint $table) {
            $table->id();
            $table->string("nameAr")->nullable();
            $table->string("nameEn")->nullable();
            $table->string("nameGr")->nullable();
            $table->string("nameFr")->nullable();
            $table->string("recognitionAr")->nullable();
            $table->foreignId('category_id')->constrained("sentence_categories")->onUpdate('cascade')->onDelete('cascade')->nullable();
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
        Schema::dropIfExists('sentences');
    }
};
