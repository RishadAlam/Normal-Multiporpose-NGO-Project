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
        Schema::create('loan_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('volume_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('center_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('type_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('registration_officer_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('client_id')->constrained('client_registers')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('acc_no');
            $table->date('start_date')->nullable();
            $table->date('duration_date')->nullable();
            $table->integer('deposit')->nullable();
            $table->integer('loan_given')->nullable();
            $table->integer('total_installment')->nullable()->comment('Installment for Recovery');
            $table->integer('interest')->nullable();
            $table->integer('total_interest')->nullable();
            $table->integer('total_loan_inc_int')->nullable()->comment('Total Loan Include Interest');
            $table->integer('loan_installment')->nullable()->comment('Fixed Loan For each installment');
            $table->integer('interest_installment')->nullable()->comment('Fixed Interest For each installment');
            // $table->integer('collected_installment')->nullable()->comment('Number of installments collected');
            $table->integer('installment_recovered')->default(0)->comment('Installment Recovered');
            $table->integer('total_deposit')->default(0)->nullable();
            $table->integer('total_withdrawal')->default(0)->comment('Total Deposit Withdrawal')->nullable();
            $table->integer('balance')->storedAs('total_deposit - total_withdrawal')->comment('balance = total_deposit - total_withdrawal');
            $table->integer('loan_recovered')->default(0)->comment('Recovered Loan')->nullable();
            $table->integer('loan_remaining')->storedAs('loan_given - loan_recovered')->comment('loan_remaining = loan_given - loan_recovered');
            $table->integer('interest_recovered')->default(0)->comment('Recovered Interest')->nullable();
            $table->integer('interest_remaining')->storedAs('total_interest - interest_recovered')->comment('interest_remaining = total_interest - interest_recovered')->nullable();
            // $table->integer('collection_ids')->comment('Collection Id from Collection Table')->nullable();
            // $table->integer('withdrawal_ids')->comment('Withdrawal Id from Withdrawal Table')->nullable();
            $table->enum('status', ['0', '1', '2'])->default(1)->comment('1 = active, 0 = deactive, 2 = hold');
            $table->string('closing_expression')->nullable();
            $table->date('closing_at')->nullable();
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
        Schema::dropIfExists('loan_profiles');
    }
};
