<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Opcional: Define los campos que se pueden asignar masivamente
    protected $fillable = ['name', 'description', 'price', 'stock', 'category_id', 'rating'];
}
