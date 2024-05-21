<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ReplaceCountryCodeWithCountryIdInHolidays extends Migration
{
    public function up()
    {
        Schema::table('holidays', function (Blueprint $table) {
            // Drop the existing country_code column
            $table->dropColumn('country_code');

            // Add the country_id column and establish a foreign key relationship
            $table->unsignedBigInteger('country_id')->nullable()->after('name');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('holidays', function (Blueprint $table) {
            // Drop the foreign key and the country_id column
            $table->dropForeign(['country_id']);
            $table->dropColumn('country_id');

            // Add back the country_code column
            $table->string('country_code', 2)->after('name');
        });
    }
}
