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
        Schema::create('saving_nominees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('saving_profile_id')->constrained('savings_profiles')->onUpdate('cascade')->onDelete('cascade');
            $table->string('name');
            $table->date('dob');
            $table->tinyInteger('segment')->nullable();
            $table->string('relation');
            $table->string('nominee_image')->nullable();
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
        Schema::dropIfExists('saving_nominees');
    }
};
