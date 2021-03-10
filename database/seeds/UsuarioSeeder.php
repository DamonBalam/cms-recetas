<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $user = User::create([
            'name' => 'Arturo',
            'email' => 'damonbalam@gmail.com',
            'password' => Hash::make('cero4cero5'),
            'url' => 'https://damonbalam.com',
        ]);


        $user2 = User::create([
            'name' => 'Angel',
            'email' => 'angel@gmail.com',
            'password' => Hash::make('cero4cero5'),
            'url' => 'https://balam.com',
        ]);


    }
}
