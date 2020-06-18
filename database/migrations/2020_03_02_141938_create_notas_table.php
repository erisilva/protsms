<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notas', function (Blueprint $table) {
            $table->increments('id');
            $table->text('conteudo');
            $table->integer('user_id')->unsigned();
            $table->integer('notaable_id');
            $table->string('notaable_type');
            $table->timestamps();
            //fk
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('anexos', function (Blueprint $table) {
            $table->dropForeign('notas_user_id_foreign');
        });
        Schema::dropIfExists('notas');
    }
}
