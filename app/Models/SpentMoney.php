<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SpentMoney extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'spent_money';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = [
        'available_money_id',
        'categories_id',
        'payments_id',
        'name',
        'description',
        'value',
        'payable',
        'date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function relCategory()
    {
        return $this->hasOne('App\Models\Category', 'id', 'categories_id');
    }

    public function relPayment()
    {
        return $this->hasOne('App\Models\Payment', 'id', 'payments_id');
    }

    public function relAvailableMoney()
    {
        return $this->hasOne('App\Models\AvailableMoney', 'id', 'available_money_id');
    }
}
