<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavoriteProductUser extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'product_id',
    ];
    protected $table = 'favorite_product_user';
}
