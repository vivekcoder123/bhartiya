<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnquiriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enquiries', function (Blueprint $table) {
            $table->id();
            $table->integer('status')->default(0);
            $table->unsignedBigInteger('service_id');
            $table->foreign('service_id')->references('id')->on('services');
            $table->string('aadhar')->nullable();
            $table->string('pan')->nullable();
            $table->string('address_proof')->nullable();
            $table->string('payslip')->nullable();
            $table->string('return_statement')->nullable();
            $table->string('bank_statement')->nullable();
            $table->string('others')->nullable();
            $table->decimal('eligible_loan_amount',20,2)->nullable();
            $table->string('time')->nullable();
            $table->unsignedBigInteger('propose_bank_id')->nullable();
            $table->foreign('propose_bank_id')->references('id')->on('banks');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('relationship_manager_id');
            $table->foreign('relationship_manager_id')->references('id')->on('staff');
            $table->enum('income_from',['Salary','Business'])->nullable();
            $table->string('company_bussiness_name')->nullable();
            $table->decimal('salary_month',22,2)->nullable();
            $table->decimal('loan_amount',20,2)->nullable();
            $table->integer('tenure')->nullable();
            $table->unsignedBigInteger('bank_id')->nullable();
            $table->foreign('bank_id')->references('id')->on('banks');
            $table->string('trading_platform')->nullable();
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
        Schema::dropIfExists('enquiries');
    }
}
