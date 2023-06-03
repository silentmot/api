<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('start_at')->index();
            $table->date('end_at')->index();
            $table->unsignedInteger('contract_number');
            $table->unsignedBigInteger('contractor_id')->index();
            $table->unsignedTinyInteger('status')->default(1)->index();

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('contractor_id')->references('id')->on('contractors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contracts');
    }
}
