<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class FavoritesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        return $user->favoriteProducts;
    }

    public function favorite(Request $request, $id)
    {
        $user = User::findOrFail(auth()->user()->id);
        $product = Product::findOrFail($id);
        $user->favoriteProducts()->attach($id);
        return response('Favorited product by id: ' . $id, 201);
    }

    public function unfavorite(Request $request, $id)
    {
        $user = User::findOrFail(auth()->user()->id);
        $product = Product::findOrFail($id);
        $user->favoriteProducts()->detach($id);
        return response('unFavorited product by id: ' . $id, 204);
    }

}
