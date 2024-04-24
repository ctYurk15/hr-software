<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrackerEntryTable extends Migration
{
    public function up()
    {
        Schema::create('tracker_entry', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->foreignId('employee_id')->constrained('users');
            $table->dateTime('start_worktime')->nullable();
            $table->dateTime('end_worktime')->nullable();
            $table->decimal('worked_time', 8, 2); // Precision and scale can be adjusted as needed
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tracker_entry');
    }
}
