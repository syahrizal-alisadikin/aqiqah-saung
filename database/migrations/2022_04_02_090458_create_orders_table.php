<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('product_id');
            $table->string('ref')->nullable();
            $table->string('name');
            $table->string('nama_ayah');
            $table->string('nama_ibu')->nullable();
            $table->string('phone');
            $table->string('quantity');
            $table->string('harga');
            $table->string('total_harga');
            $table->string('alamat')->nullable();
            $table->string('note')->nullable();
            $table->string('status')->default('PENDING',"POTONG","KIRIM","SELESAI","BATAL","LUNAS");
            $table->date('tanggal_potong');
            $table->date('tanggal_acara')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('orders');
    }
}
