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
        // $this->call(UserSeeder::class);
        DB::table('interieur_users')->insert([
            'name' => 'Admin',
            'email' => 'admin@email.com',
            'password' => Hash::make('adminpass1234'),
            'usertype' => 1,
        ]);
    }
}
