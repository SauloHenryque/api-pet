<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('users')->truncate();

        \App\User::create([
            'email'     => 'administrador@email.com',
            'name'      => 'Usuário Administrador',
            'password'  => bcrypt('pets'),
        ]);

        $this->command->info('User administrador@email.com created');
    }
}
