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
        Schema::create('saving_withdrawals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('saving_profile_id')->constrained('savings_profiles')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('volume_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('center_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('type_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('officer_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('client_id')->constrained('client_registers')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('acc_no');
            $table->integer('balance');
            $table->integer('withdraw');
            $table->integer('balance_remaining');
            $table->mediumText('expression')->nullable();
            $table->enum('status', ['0', '1', '2'])->default(2)->comment('0= deactive, 1= active, 2= panding');
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
        Schema::dropIfExists('saving_withdrawals');
    }
};
