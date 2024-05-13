<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVacationsTable extends Migration
{
    public function up()
    {
        Schema::create('vacations', function (Blueprint $table) {
            $table->id();
            $table->date('from_date');
            $table->date('to_date');
            $table->foreignId('employee_id')->constrained('users'); // Assuming 'users' is the name of your user table
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vacations');
    }
}
