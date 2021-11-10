<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('merk_id');
            $table->unsignedInteger('kategori_id');
            $table->string('nama_produk', 100);
            $table->string('detail')->nullable();
            // $table->integer('qty');
            $table->integer('ppn');
            $table->decimal('harga_modal');
            $table->decimal('harga_jual');
            $table->string('no_rak')->nullable();
            $table->string('img_path')->nullable();
            $table->boolean('is_active');
            $table->timestamps();
            $table->softDeletes();
            $table->bigInteger('created_by');
            $table->bigInteger('updated_by');
            $table->bigInteger('deleted_by')->nullable();
            $table->string('deleted_remark')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
