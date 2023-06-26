<?php
namespace database\seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use database\seeders\UsersTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'nome' => 'Admin',
            'usuario' => 'admin',
            'email' => 'admin@admin.com.br',
            'senha' => Hash::make('654321'),
        ]);
    }
}
