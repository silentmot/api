<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModuleFieldInRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('permissions', function (Blueprint $table) {
            $table->string('module')->after('description')->index();
        });

        Schema::table('roles', function (Blueprint $table) {
            $table->index('display_name');
            $table->dropIndex('roles_name_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('permissions', function (Blueprint $table) {
            $table->dropColumn('module');
        });

        Schema::table('roles', function (Blueprint $table) {
            $table->unique('name');
            $table->dropIndex(['display_name']);
        });
    }
}
