<?php

use Illuminate\Database\Seeder;

class ProtocoloTiposTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('protocolo_tipos')->insert([
            'descricao' => 'Não Definido',
        ]);

        DB::table('protocolo_tipos')->insert([
            'descricao' => 'Memorando',
        ]);

        DB::table('protocolo_tipos')->insert([
            'descricao' => 'Ofício',
        ]);

        DB::table('protocolo_tipos')->insert([
            'descricao' => 'Solicitação',
        ]);

        DB::table('protocolo_tipos')->insert([
            'descricao' => 'Documentos',
        ]);

        DB::table('protocolo_tipos')->insert([
            'descricao' => 'Laudos',
        ]);
    }
}
