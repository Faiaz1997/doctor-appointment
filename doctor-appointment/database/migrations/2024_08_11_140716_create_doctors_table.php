<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorsTable extends Migration
{
  
    public function up()
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('department_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('phone');
            $table->decimal('fee', 8, 2);
            $table->timestamps();
        });
    }

  
    public function down()
    {
        Schema::dropIfExists('doctors');
    }
}
