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
        Schema::create('loan_profile_checks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loan_profile_id')->constrained('loan_profiles')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('officer_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('acc_no');
            $table->integer('balance');
            $table->integer('loan_recovered');
            $table->integer('loan_remaining');
            $table->integer('interest_recovered');
            $table->integer('interest_remaining');
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
        Schema::dropIfExists('loan_profile_checks');
    }
};
