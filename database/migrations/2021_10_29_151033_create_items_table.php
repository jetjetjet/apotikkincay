<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('merk_id');
            $table->unsignedInteger('kategori_id');
            $table->string('nama_item', 100);
            $table->string('detail')->nullable();
            $table->integer('qty');
            $table->integer('ppn');
            $table->decimal('harga_modal');
            $table->decimal('harga_jual');
            $table->string('no_rak')->nullable();
            $table->string('path_file')->nullable();
            $table->string('status_item');
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
        Schema::dropIfExists('items');
    }
}
