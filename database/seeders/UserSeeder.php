<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!User::where('email', 'camila@gmail.com.br')->first()) {
            $superAdmin = User::create([
                'name' => 'Camila',
                'email' => 'camila@gmail.com.br',
                'password' => Hash::make('7654321a', ['rounds' => 12])
            ]);
    }
}

}
