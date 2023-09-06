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
        Schema::create('restaurants', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->string('name')->nullable();
            $table->string('name_katakana')->nullable();
            $table->double('review', 2, 1)->nullable();
            $table->integer('numComments')->nullable();
            $table->string('food_picture')->nullable();
            $table->string('map_url')->nullable();
            $table->string('phone_number')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurants');
    }
};
