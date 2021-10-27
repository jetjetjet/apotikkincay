<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('nama_lengkap')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('alamat')->nullable();
            $table->string('kontak')->nullable();
            $table->string('jen_kel')->nullable();
            $table->date('tgl_masuk')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
            $table->bigInteger('deleted_by')->nullable();
            $table->bigInteger('created_by');
            $table->bigInteger('updated_by')->nullable();
    
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
