<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    protected $fillable = [
        'title', 'description', 'price'
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
