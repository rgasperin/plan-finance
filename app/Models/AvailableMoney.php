<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AvailableMoney extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'available_money';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = [
        'user_id',
        'name',
        'to_spend',
        'date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function relSpentMoney()
    {
        return $this->hasMany('App\Models\SpentMoney', 'available_money_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
