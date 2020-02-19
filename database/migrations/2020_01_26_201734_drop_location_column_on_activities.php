<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropLocationColumnOnActivities extends Migration
{
    public function up()
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->dropColumn('location');
        });
    }
}
