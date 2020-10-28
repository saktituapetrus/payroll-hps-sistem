<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoanCustomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_customs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('employee_id');
            $table->enum('loan_type', ['salary', 'bonus']);
            $table->integer('loan_amount');
            $table->integer('tenor');
            $table->date('loan_date');
            $table->enum('status', [0, 1])->default(0)->nullable();
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
        Schema::dropIfExists('loan_customs');
    }
}
