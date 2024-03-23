<?php

namespace App\Actions;

use App\Gateways\ProductGateway;
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
            $product->subcategory_id = $request->subcategory_id;
            $product->description = $request->description;
            $product->price = $request->price;
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
        abort_unless((bool) $product, 404, "Product not found");
        $product->number = $data->number;
        $product->days = $data->days;
        $product->status = $data->status;
        $product->user_id = $data->user_id;
        $product->save();
        return $product;
    }

    public static function delete(int $productId)
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
