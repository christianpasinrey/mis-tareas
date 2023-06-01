<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'=>'Christian',
            'lastname'=> 'Pasín Rey',
            'alias'=> 'Christian',
            'email'=>'christian.pasin.rey@gmail.com',
            'password'=>Hash::make('12345679'),
            'birthday' => '1988-01-05',
            'remember_token' => Str::random(10),
        ]);
        User::factory()->count(10)->create();
        return;
    }
}
