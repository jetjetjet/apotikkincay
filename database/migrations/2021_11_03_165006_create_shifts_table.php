<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShiftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shifts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->integer('index');
            $table->datetime('shift_start');
            $table->datetime('shift_end')->nullable();
            $table->decimal('start_cash', 16,0);
            $table->decimal('start_coin', 16,0);
            $table->decimal('end_cash', 16,0)->nullable();
            $table->decimal('end_coin', 16,0)->nullable();
            $table->string('remark')->nullable();

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
        Schema::dropIfExists('shifts');
    }
}
