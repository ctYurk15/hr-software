<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnsToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->date('birthdate')->nullable();
            $table->string('phone')->nullable();
            $table->string('region')->nullable();
            $table->date('start_work_date')->nullable();

            // Add an integer column for each weekday
            $table->integer('working_time_monday')->nullable();
            $table->integer('working_time_tuesday')->nullable();
            $table->integer('working_time_wednesday')->nullable();
            $table->integer('working_time_thursday')->nullable();
            $table->integer('working_time_friday')->nullable();
            $table->integer('working_time_saturday')->nullable();
            $table->integer('working_time_sunday')->nullable();

            $table->integer('current_year_overtime')->nullable();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'firstname',
                'lastname',
                'birthdate',
                'phone',
                'region',
                'start_work_date',
                'working_time_monday',
                'working_time_tuesday',
                'working_time_wednesday',
                'working_time_thursday',
                'working_time_friday',
                'working_time_saturday',
                'working_time_sunday',
                'current_year_overtime'
            ]);
        });
    }
}

