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
        Schema::create('words', function (Blueprint $table) {
            $table->id();
            $table->string("nameAr")->nullable();
            $table->string("nameEn")->nullable();
            $table->string("nameFr")->nullable();
            $table->string("nameGr")->nullable();
            $table->string("image")->nullable();
            $table->foreignId('category_id')->constrained("words_categories")->onUpdate('cascade')->onDelete('cascade')->nullable();
            $table->string("recognitionEn")->nullable();
            $table->string("recognitionGr")->nullable();
            $table->string("recognitionFr")->nullable();
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
        Schema::dropIfExists('words');
    }
};
