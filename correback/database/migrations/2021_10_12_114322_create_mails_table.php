<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mails', function (Blueprint $table) {
            $table->id();
            $table->string("codigo");
            $table->string("tipo");
            $table->string("tipo")->default('ARCHIVO');
            $table->string("ref");
            $table->date("fecha");
            $table->date("fechacarta");
            $table->string("estado");
            $table->string("folio");
            $table->string("archivo");
            $table->string("codinterno")->nullable();
            $table->string("codexterno")->nullable();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('unit_id');
            $table->foreign('unit_id')->references('id')->on('units');
            $table->unsignedBigInteger('mail_id')->nullable()->default(null);
            $table->foreign('mail_id')->references('id')->on('mails');
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
        Schema::dropIfExists('mails');
    }
}
