<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMobSupervisorOTPTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mob_supervisor_otp', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('contact_id')->index();
            $table->unsignedMediumInteger('otp_code')->index();
            $table->timestamp('expires_at')->nullable();

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
        Schema::dropIfExists('mob_supervisor_otp');
    }
}
