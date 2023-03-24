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
        Schema::create('savings_to_loans_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('from_volume_id')->constrained('volumes')->onUpdate('cascade')->onDelete('cascade')->comment('From Sanding Transaction Account');
            $table->foreignId('from_center_id')->constrained('centers')->onUpdate('cascade')->onDelete('cascade')->comment('From Sanding Transaction Account');
            $table->foreignId('from_type_id')->constrained('types')->onUpdate('cascade')->onDelete('cascade')->comment('From Sanding Transaction Account');
            $table->foreignId('from_client_id')->constrained('client_registers')->onUpdate('cascade')->onDelete('cascade')->comment('From Sanding Transaction Account');
            $table->foreignId('from_saving_profile_id')->constrained('savings_profiles')->onUpdate('cascade')->onDelete('cascade')->comment('From Sanding Transaction Account');
            $table->integer('from_acc_no')->comment('From Sanding Transaction Account');
            $table->integer('from_acc_main_balance')->comment('From Sanding Transaction Account');
            $table->integer('from_acc_trans_balance')->comment('From Sanding Transaction Account');

            $table->foreignId('to_volume_id')->constrained('volumes')->onUpdate('cascade')->onDelete('cascade')->comment('To Receiving Transaction Account');
            $table->foreignId('to_center_id')->constrained('centers')->onUpdate('cascade')->onDelete('cascade')->comment('To Receiving Transaction Account');
            $table->foreignId('to_type_id')->constrained('types')->onUpdate('cascade')->onDelete('cascade')->comment('To Receiving Transaction Account');
            $table->foreignId('to_client_id')->constrained('client_registers')->onUpdate('cascade')->onDelete('cascade')->comment('To Receiving Transaction Account');
            $table->foreignId('to_loan_profile_id')->constrained('loan_profiles')->onUpdate('cascade')->onDelete('cascade')->comment('To Receiving Transaction Account');
            $table->integer('to_acc_no')->comment('To Receiving Transaction Account');
            $table->integer('to_acc_main_balance')->comment('To Sanding Transaction Account');
            $table->integer('to_acc_trans_balance')->comment('To Sanding Transaction Account');

            $table->foreignId('officer_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('amount')->comment('Transaction Amount');
            $table->mediumText('expression')->nullable();
            $table->enum('status', ['0', '1', '2'])->default('2')->comment('0 = Deactive, 1 = Active, 2 = Panding');
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
        Schema::dropIfExists('savings_to_loans_transactions');
    }
};
