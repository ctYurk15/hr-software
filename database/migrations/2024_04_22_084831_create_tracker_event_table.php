<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrackerEventTable extends Migration
{
    public function up()
    {
        Schema::create('tracker_event', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tracker_id')->constrained('tracker_entry');
            $table->string('type');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tracker_event');
    }
}
