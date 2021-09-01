<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionsAndRolesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('label')->nullable();
//            $table->timestamps();
        });
        Schema::create('permission_user', function (Blueprint $table) {
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');
            $table->foreignId('permission_id')
                ->constrained('permissions')
                ->onDelete('cascade');
            $table->primary(['permission_id','user_id']);
        });
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('label')->nullable();
//            $table->timestamps();
        });
        Schema::create('permission_role', function (Blueprint $table) {
            $table->foreignId('role_id')
                ->constrained('roles')
                ->onDelete('cascade');
            $table->foreignId('permission_id')
                ->constrained('permissions')
                ->onDelete('cascade');
            $table->primary(['permission_id','role_id']);
        });
        Schema::create('role_user', function (Blueprint $table) {
            $table->foreignId('role_id')
                ->constrained('roles')
                ->onDelete('cascade');
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');
            $table->primary(['user_id','role_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permission_user');
        Schema::dropIfExists('role_user');
        Schema::dropIfExists('permission_role');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('permissions');
    }
}
