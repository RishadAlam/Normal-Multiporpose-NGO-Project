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
        Schema::create('savings_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('volume_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('center_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('type_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('registration_officer_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('client_id')->constrained('client_registers')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('acc_no');
            $table->date('start_date')->nullable();
            $table->date('duration_date')->nullable();
            $table->integer('deposit');
            $table->tinyInteger('installment');
            $table->integer('total_except_interest');
            $table->tinyInteger('interest');
            $table->integer('total_include_interest');
            $table->integer('total_deposit')->default(0)->nullable();
            $table->integer('total_withdrawal')->default(0)->nullable();
            $table->integer('balance')->storedAs('total_deposit - total_withdrawal')->comment('balance = total_deposit - total_withdrawal');
            // $table->string('collection_ids')->nullable()->comment('Collection Id from Collection Table');
            // $table->string('withdrawal_ids')->nullable()->comment('Withdrawal Id from Withdrawal Table');
            $table->enum('status', ['0', '1', '2'])->default(1)->comment('0=deactive, 1=active, 2=hold');
            $table->string('closing_interest')->nullable();
            $table->string('closing_balance_include_interest')->nullable();
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
        Schema::dropIfExists('savings_profiles');
    }
};
