<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('report_to_id');
            $table->foreign('report_to_id')->references('id')->on('staff');
            $table->string('employee_id')->unique();
            $table->unsignedBigInteger('location_id');
            $table->foreign('location_id')->references('id')->on('locations');
            $table->unsignedBigInteger('designation_id');
            $table->foreign('designation_id')->references('id')->on('designations');
            $table->string('name');
            $table->string('email')->unique();
            $table->integer('mobile_number')->unique();
            $table->date('doj')->nullable();
            $table->string('address')->nullable();
            $table->string('current_address')->nullable();
            $table->string('emergency_contact')->nullable();
            $table->string('blood_group')->nullable();
            $table->string('qualification')->nullable();
            $table->date('dob')->nullable();
            $table->string('pan')->nullable();
            $table->string('aadhar')->nullable();
            $table->string('resume')->nullable();
            $table->string('exp_cert')->nullable();
            $table->string('qual_cert')->nullable();
            $table->enum('marital_status', ['S', 'M'])->nullable();
            $table->string('family_members')->nullable();
            $table->date('anniversary')->nullable();
            $table->string("password");
            $table->string("permissions")->nullable();
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
        Schema::dropIfExists('staff');
    }
}
