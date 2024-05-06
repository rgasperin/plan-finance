<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpentMoney extends Model
{
    use HasFactory;

    protected $table = 'spent_money';

    protected $dates = ['created_at','updated_at','deleted_at'];

    protected $fillable = [
        'available_money_id',
        'categories_id',
        'name',
        'description',
        'value',
        'data',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function relCategory() {
        return $this->hasOne('App\Models\Category', 'id', 'categories_id');
    }

    public function relAvailableMoney() {
        return $this->hasOne('App\Models\AvailableMoney', 'id', 'available_money_id');
    }
}
