<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProtocoloTramitacaosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('protocolo_tramitacaos', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('protocolo_id')->unsigned();

            // quem criou a tramitação, user e setor
            $table->integer('user_id_origem')->unsigned();
            $table->integer('setor_id_origem')->unsigned();
            // funcionário e setor que fará o recebimento do protocolo
            $table->integer('user_id_destino')->unsigned();
            $table->integer('setor_id_destino')->unsigned();
            // texto opcional que poderá ser usado para enviar uma mensagem ou uma nota ao funcionário destino
            $table->text('mensagem')->nullable();

            // onde defini-se se o funcionário recebeu e quando o protocolo
            $table->dateTime('recebido_em')->nullable();
            // se tiver sim, não será possível estornar essa marcação (verfificar)
            $table->enum('recebido', ['s', 'n']);
            // ao se clicar em recebido poderá ser incorporado uma nota a trmitação
            $table->text('mensagemRecebido')->nullable();

            // essa é a opção que fecha a tramitação, para isso o funcionário deverá criar uma nova tramitação
            // nota 1: só pode fazer a tramitação pelo funcionário de destino
            // nota 2: o funcionário só pode tramitar apenas uma vez (verificar)
            // nota 3: não é possível tramitar sem antes marcar como recebido ou ao tramitar o recebimento será automatico, caso necessário
            $table->dateTime('tramitado_em')->nullable();
            $table->enum('tramitado', ['s', 'n']);

            $table->timestamps();

            $table->foreign('protocolo_id')->references('id')->on('protocolos')->onDelete('cascade');
            $table->foreign('user_id_origem')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('setor_id_origem')->references('id')->on('setors')->onDelete('cascade');
            $table->foreign('user_id_destino')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('setor_id_destino')->references('id')->on('setors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('protocolo_tramitacaos', function (Blueprint $table) {
            $table->dropForeign('protocolo_tramitacaos_protocolo_id_foreign');
            
            $table->dropForeign('protocolo_tramitacaos_user_id_origem_foreign');
            $table->dropForeign('protocolo_tramitacaos_setor_id_origem_foreign');
            
            $table->dropForeign('protocolo_tramitacaos_user_id_destino_foreign');
            $table->dropForeign('protocolo_tramitacaos_setor_id_destino_foreign');
        });

        Schema::dropIfExists('protocolo_tramitacaos');
    }
}
