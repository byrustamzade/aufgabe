<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'category_id',
        'distance',
        'price',
        'veggie_suitable'
    ];

    public function address()
    {
        return $this->hasOne(Address::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
