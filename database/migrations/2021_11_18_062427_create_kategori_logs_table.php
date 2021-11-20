<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKategoriLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kategori_log', function (Blueprint $table) {
          $table->id();
          $table->bigInteger('user_id');
          $table->bigInteger('reference_id');
          $table->text('action');
          $table->text('ip_address');
          $table->longText('value');
          $table->longText('old_value')->nullable();
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
        Schema::dropIfExists('kategori_log');
    }
}
