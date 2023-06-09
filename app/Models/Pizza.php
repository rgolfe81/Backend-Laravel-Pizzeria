<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pizza extends Model
{
    use HasFactory;

    protected $table = 'pizza';

    public function reviews(){
        return $this-> hasMany(Review::class);
    }

    public function ingredients(){
        return $this-> belongsToMany(Ingredient::class, 'ingredient_pizza');
    }

}
