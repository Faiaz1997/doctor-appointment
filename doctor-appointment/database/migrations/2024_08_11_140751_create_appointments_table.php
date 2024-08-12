<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{

    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->string('appointment_no')->unique();
            $table->date('appointment_date');
            $table->foreignId('doctor_id')->constrained()->onDelete('cascade');
            $table->string('patient_name');
            $table->string('patient_phone');
            $table->decimal('total_fee', 8, 2);
            $table->decimal('paid_amount', 8, 2);
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('appointments');
    }
}
