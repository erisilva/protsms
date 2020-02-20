<?php

use Illuminate\Database\Seeder;

class SetoresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('setors')->insert([
            'codigo' => '1',
            'descricao' => 'Não Definido',
        ]);

        DB::table('setors')->insert([
            'codigo' => '1130',
            'descricao' => 'Diretoria de tecnologia da informática',
        ]);

    }
}
