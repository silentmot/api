<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIntegrationLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('integration_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('log_id')->nullable()->index();
            $table->unsignedSmallInteger('log_order')->default(0);
            $table->string('status')->nullable()->index();
            $table->string('event_name')->nullable()->index();
            $table->string('client')->nullable()->index();
            $table->longText('data')->nullable();
            $table->longText('request')->nullable();
            $table->longText('response')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('integration_logs');
    }
}
