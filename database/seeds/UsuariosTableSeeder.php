<?php

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuariosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'nome' => 'Vox Digital',
            'usuario' => 'vox',
            'email' => 'davi@voxdigital.com.br',
            'senha' => Hash::make('vox@2018'),
            'remember_token' => Str::random(60),
        ]);
    }
}
