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
        Schema::create('savings_profile_checks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('saving_profile_id')->constrained('savings_profiles')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('officer_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('acc_no');
            $table->integer('balance');
            $table->mediumText('expression')->nullable();
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
        Schema::dropIfExists('savings_profile_checks');
    }
};
