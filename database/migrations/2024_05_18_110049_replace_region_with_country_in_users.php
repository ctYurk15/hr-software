<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ReplaceRegionWithCountryInUsers extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Assuming the 'region' column exists and needs to be dropped
            if (Schema::hasColumn('users', 'region')) {
                $table->dropColumn('region');
            }

            // Add the country_id column which can be nullable
            $table->unsignedBigInteger('country_id')->nullable()->after('email');

            // Add the foreign key constraint
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'country_id')) {
                // Drop the foreign key before dropping the column
                $table->dropForeign(['country_id']);
                $table->dropColumn('country_id');
            }

            // Optionally re-add the region column if needed
            $table->string('region')->nullable()->after('email');
        });
    }
}
