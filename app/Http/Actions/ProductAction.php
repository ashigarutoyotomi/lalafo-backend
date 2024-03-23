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
            if ($request->photos != null) {
                foreach ($request->file('photos') as $photo) {
                    $filename = uniqid() . '_' . time() . '.' . $photo->getClientOriginalExtension();

                    $path = $photo->storeAs('photos', $filename, 'public');

                    $photoModel = new ProductPhoto;
                    $photoModel->path = $path;
                    $photoModel->save();
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

    public function update($data)
    {
        $product = (new ProductGateway)->getById($data->id);
        try {
            DB::beginTransaction();

            abort_unless((bool) $product, 404, "Product not found");
            if ($data->name != null) {
                $product->name = $data->name;
            }
            if ($data->subcategory_id != null) {
                $product->subcategory_id = $data->subcategory_id;
            }
            if ($data->price != null) {
                $product->price = $data->price;
            }
            if ($data->decription != null) {
                $product->decription = $data->decription;
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

}
