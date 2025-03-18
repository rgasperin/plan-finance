<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(!Category::where('name','Mercado' )->first()){
            Category::create([
                'user_id' => 1,
                'name' => 'Mercado',
                'color' => '#25AE26',
            ]);
        }
        if(!Category::where('name','Compras Online' )->first()){
            Category::create([
                'user_id' => 1,
                'name' => 'Compras Online',
                'color' => '#AE3E3E',
            ]);
        }
        if(!Category::where('name','Carro' )->first()){
            Category::create([
                'user_id' => 1,
                'name' => 'Carro',
                'color' => '#808080',
            ]);
        }
    
    }
}
