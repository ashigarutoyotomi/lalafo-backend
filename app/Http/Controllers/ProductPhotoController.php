<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductPhoto;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductPhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
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
            $fileName = time() . '_' . $photo->getClientOriginalName();
            $photo->storeAs('photos', $fileName, 'public');

            $product_photo = new ProductPhoto;
            $product_photo->path = 'storage/photos/' . $fileName;
            $product_photo->product_id = $request->product_id;
            $product_photo->save();

            return response('Product created successfully.', 201);
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
    public function destroy(int $id)
    {
        $product_photo = ProductPhoto::findOrFail($id);
        try {
            DB::beginTransaction();
            $product_photo->delete();
            if (Storage::disk('public')->exists('storage/photos/' . $product_photo->photo_path)) {
                Storage::disk('public')->delete('storage/photos/' . $product_photo->photo_path);
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }
}
