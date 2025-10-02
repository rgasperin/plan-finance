<?php

namespace Database\Seeders;

use App\Models\Payment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{

    public function run(): void
    {
        if(!Payment::where('name','Cartão de Crédito' )->first()){
            Payment::create([    
                'name' => 'Cartão de Crédito',
            ]);
        }
        if(!Payment::where('name','Pix' )->first()){
            Payment::create([    
                'name' => 'Pix',
            ]);
        }
        if(!Payment::where('name','Débito' )->first()){
            Payment::create([    
                'name' => 'Débito',
            ]);
        }
        if(!Payment::where('name','Dinheiro' )->first()){
            Payment::create([
                'name' => 'Dinheiro',        
            ]);
        }
    }
}
