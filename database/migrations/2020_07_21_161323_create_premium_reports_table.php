<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePremiumReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('premium_reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('due_date');
            $table->integer('client_id');
            $table->integer('work_id');
            $table->integer('company_id');
            $table->string('unique_number');
            $table->decimal('amount', 10,2);
            $table->enum('status',['Pending','Completed','Hold','Prospect'])->default('Pending');
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
        Schema::dropIfExists('premium_reports');
    }
}
