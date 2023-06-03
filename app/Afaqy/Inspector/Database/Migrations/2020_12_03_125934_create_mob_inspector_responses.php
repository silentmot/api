<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMobInspectorResponses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mob_inspector_responses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->morphs('responseable');
            $table->unsignedBigInteger('ticket_id')->index();
            $table->text('details');

            $table->timestamps();

            $table->foreign('ticket_id')
                ->references('id')
                ->on('mob_inspector_tickets');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mob_inspector_responses');
    }
}
