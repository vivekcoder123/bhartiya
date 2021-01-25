<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('service_type');
            $table->integer('min_tenure');
            $table->integer('max_tenure');
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    // $table->string('loan_number');
    // $table->double('amount',18,2);
    // $table->double('interest',13,2);
    // $table->date('disbursement_date');
    // $table->date('borrowing_date');
    // $table->date('repayment_date');
    // $table->integer('term');
    // $table->text('remarks')->nullable();
    // $table->unsignedBigInteger('loan_type_id');
    // $table->foreign('loan_type_id')->references('id')->on('loan_types');
    // $table->unsignedBigInteger('borrowing_type_id');
    // $table->foreign('borrowing_type_id')->references('id')->on('borrowing_types');

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('services');
    }
}
