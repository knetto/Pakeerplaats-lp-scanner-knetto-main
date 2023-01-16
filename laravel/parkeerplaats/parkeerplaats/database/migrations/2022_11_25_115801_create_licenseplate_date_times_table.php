<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('licenseplate_date_times', function (Blueprint $table) {
            $table->id();
            $table->integer("plate_id");
            $table->dateTime("dateTime_in");
            $table->dateTime("dateTime_out");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('licenseplate_date_times');
    }
};
