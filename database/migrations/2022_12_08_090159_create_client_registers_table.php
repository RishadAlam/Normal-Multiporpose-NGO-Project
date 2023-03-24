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
        Schema::create('client_registers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('volume_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('center_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('registration_officer_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('acc_no')->unique();
            $table->integer('share')->default(0);
            $table->string('name');
            $table->string('husband_or_father_name');
            $table->string('mother_name');
            $table->string('nid', 25);
            $table->string('academic_qualification')->nullable();
            $table->date('dob');
            $table->string('religion');
            $table->string('occupation');
            $table->string('gender');
            $table->string('mobile', 11);
            $table->string('client_image');
            $table->mediumText('Present_address');
            $table->mediumText('permanent_address');
            $table->softDeletes();
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
        Schema::dropIfExists('client_registers');
    }
};
