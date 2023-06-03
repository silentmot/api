<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMobInspectorTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mob_inspector_tickets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('contract_id')->index();
            $table->string('contractor_name');
            $table->unsignedBigInteger('district_id');
            $table->unsignedBigInteger('neighborhood_id');
            $table->string('location');
            $table->string('location_name');
            $table->enum('status', ['PENDING', 'RESPONDED', 'ACCEPTED','REPORTED', 'PENALTY','APPROVED']);
            $table->text('details')->nullable();
            $table->boolean('is_viewed')->default(false);
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users');

            $table->foreign('contract_id')
                ->references('id')
                ->on('contracts');

            $table->foreign('district_id')
                ->references('id')
                ->on('districts');

            $table->foreign('neighborhood_id')
                ->references('id')
                ->on('neighborhoods');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mob_inspector_tickets');
    }
}
