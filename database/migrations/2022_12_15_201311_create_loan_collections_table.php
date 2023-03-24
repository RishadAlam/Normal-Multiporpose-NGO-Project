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
        Schema::create('loan_collections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loan_profile_id')->constrained('loan_profiles')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('volume_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('center_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('type_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('officer_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('client_id')->constrained('client_registers')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('acc_no');
            $table->integer('installment')->comment('Recovered Loan quantity');
            $table->integer('deposit');
            $table->integer('loan');
            $table->integer('interest');
            $table->integer('total');
            $table->mediumText('expression')->nullable();
            $table->enum('status', ['0', '1', '2'])->default('2')->comment('0 = Deactive, 1 = Active, 2 = Panding');
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
        Schema::dropIfExists('loan_collections');
    }
};
