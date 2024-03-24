<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'description', 'price', 'subcategory_id', 'user_id', 'activated'];

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function photos()
    {
        return $this->hasMany(ProductPhoto::class);
    }
    public function favoritedByUsers()
    {
        return $this->belongsToMany(User::class, 'favorite_product_user', 'product_id', 'user_id')->withTimestamps();
    }
}
