<?php

namespace App\Http\Actions;

use App\Http\Gateways\ProductGateway;
use App\Models\Product;
use App\Models\ProductPhoto;
use Exception;
use Illuminate\Support\Facades\DB;

class ProductAction
{
    public function create($request)
    {
        try {
            DB::beginTransaction();
            $product = new Product;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->name = $request->name;
            $product->user_id = $request->user_id;
            $product->subcategory_id = $request->subcategory_id;
            $product->activated = true;
            if ($request->photos != null) {
                foreach ($request->file('photos') as $file) {
                    if ($file && $file->isValid()) {
                        $fileName = time() . '_' . $file->getClientOriginalName();
                        $file->storeAs('photos', $fileName, 'public');

                        $product_photo = new ProductPhoto;
                        $product_photo->path = 'storage/photos/' . $fileName;
                        $product_photo->product_id = $request->product_id;
                        $product_photo->save();
                    }
                }
            }

            $product->save();
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
        return $product;
    }

    public function update($request, $productId)
    {
        $product = (new ProductGateway)->getById($productId);
        try {
            DB::beginTransaction();

            abort_unless((bool) $product, 404, "Product not found");
            if ($request->name != null) {
                $product->name = $request->name;
            }
            if ($request->subcategory_id != null) {
                $product->subcategory_id = $request->subcategory_id;
            }
            if ($request->price != null) {
                $product->price = $request->price;
            }
            if ($request->description != null) {
                $product->description = $request->description;
            }
            $product->save();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
        return $product;
    }

    public static function destroy(int $productId)
    {
        try {
            DB::beginTransaction();
            $product = (new ProductGateway)->getById($productId);
            abort_unless((bool) $product, 404, "Product not found");
            $product->delete();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
        return $product;
    }
    public function switch($productId)
    {
            $product = (new ProductGateway)->getById($productId);
            try {
                DB::beginTransaction();

                abort_unless((bool) $product, 404, "Product not found");
                $product->activated = !$product->activated;
                $product->save();
                DB::commit();
            } catch (Exception $e) {
                DB::rollBack();
                return $e->getMessage();
            }
            return $product;
    }
}
