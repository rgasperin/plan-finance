<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class AvailableMoney extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'available_money';

    protected $dates = ['created_at','updated_at','deleted_at'];

    protected $fillable = [
        'to_spend',
        'total_value',
        'date',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function relSpentMoney() {
        return $this->hasMany('App\Models\SpentMoney', 'available_money_id');
    }
}
