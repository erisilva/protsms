<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(SetoresTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(PerpagesTableSeeder::class);
        $this->call(ProtocoloTiposTableSeeder::class);
        $this->call(ProtocoloSituacoesTableSeeder::class);
        $this->call(AclSeeder::class);
    }
}
