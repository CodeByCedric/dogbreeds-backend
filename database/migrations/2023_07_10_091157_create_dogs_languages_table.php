<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('dogs_languages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("dog_id");
            $table->string("language");
            $table->string("name");
            $table->text("description");
            $table->timestamps();

            $table->foreign('dog_id')->references('id')->on('dogs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dogs_languages');
    }
};
