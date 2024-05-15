<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSicklistsTable extends Migration
{
    public function up()
    {
        Schema::create('sicklists', function (Blueprint $table) {
            $table->id();
            $table->date('from_date');
            $table->date('to_date');
            $table->unsignedBigInteger('employee_id'); // Assuming your users table uses bigint for ID
            $table->text('description')->nullable();
            $table->timestamps();

            // Setting up the foreign key relation
            $table->foreign('employee_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('sicklists');
    }
}

