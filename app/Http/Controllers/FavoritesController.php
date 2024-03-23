<?php

namespace App\Http\Controllers;

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

    public function favorite(Request $request)
    {
        $user = User::find(auth()->user()->id);
        $user->favoriteProducts()->attach($request->product_id);
        return response('Favorited product by id: ' . $request->product_id, 201);
    }

    public function unfavorite(Request $request)
    {
        $user = User::find(auth()->user()->id);
        $user->favoriteProducts()->detach($request->product_id);
        return response('unFavorited product by id: ' . $request->product_id, 201);
    }

}
