<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'categories';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = [
        'user_id',
        'name',
        'color',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function relSpentMoney()
    {
        return $this->hasMany('App\Models\SpentMoney', 'categories_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
