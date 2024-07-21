<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payments';

    protected $fillable = [
        'name',
    ];

    public function relSpentMoney()
    {
        return $this->hasMany('App\Models\SpentMoney', 'payments_id');
    }
}
