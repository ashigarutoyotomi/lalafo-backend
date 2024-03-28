<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductPhoto;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductPhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate(['product_id' => 'required|integer|exists:products,id']);
        $product = Product::findOrFail($request->product_id);
        return $product->photos;

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'product_id' => 'required|integer|exists:products,id',
        ]);

        if ($request->hasFile('photo') && $request->photo->isValid()) {
            $photo = $request->file('photo');
            $fileName = time() . '_' . Str::random(10);
            $photo->storeAs('photos', $fileName, 'public');

            $product_photo = new ProductPhoto;
            $product_photo->path = $fileName;
            $product_photo->product_id = $request->product_id;
            $product_photo->save();

            return response('Product Photo created successfully.', 201);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(ProductPhoto $productPhoto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductPhoto $productPhoto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, int $id)
    {
        $product_photo = ProductPhoto::findOrFail($id);

        try {
            DB::beginTransaction();

            if (Storage::exists('public/photos/' . $product_photo->path)) {
                Storage::delete('public/photos/' . $product_photo->path);
            }
            $product_photo->delete();
            DB::commit();
            return response('Deleted successfully', 204);
        } catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }
}
