<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $password = Crypt::encryptString('123456789');
        DB::table('users')->insert(array(
            'id' => 111111,
            'name' => 'ADMIN',
            'lstname' => 'ADMIN',
            'email' => 'admin@correo.com',
            'password' => $password,
            'created_at' => date('Y-m-d'),
            'role' => 'ROLE_ADM',
            'photo' => null
        ));

        DB::table('users')->insert(array(
            'id' => 222222,
            'name' => 'USER',
            'lstname' => 'USER',
            'email' => 'user@correo.com',
            'password' => $password,
            'created_at' => date('Y-m-d'),
            'role' => 'ROLE_USR',
            'photo' => null
        ));

        $this->command->info('semilla plantada!!');
    }
}
