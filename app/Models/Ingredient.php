<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;

    protected $table = 'ingredient';

    public function pizza()
    {
        return $this->belongsToMany(Pizza::class, 'ingredient_pizza');
    }
}
