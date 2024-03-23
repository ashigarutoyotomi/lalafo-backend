<?php

namespace App\Actions;

use App\Gateways\ProductGateway;
use App\Models\Product;

class ProductAction
{
    public function create($data)
    {
        return Product::create($data->toArray());
    }

    public function update($data)
    {
        $simcard = (new ProductGateway)->getById($data->id);
        abort_unless((bool) $simcard, 404, "Product not found");
        $simcard->number = $data->number;
        $simcard->days = $data->days;
        $simcard->status = $data->status;
        $simcard->user_id = $data->user_id;
        $simcard->save();
        return $simcard;
    }

    public function delete(int $simcardId)
    {
        $simcard = (new ProductGateway)->getById($simcardId);
        abort_unless((bool) $simcard, 404, "Product not found");
        $simcard->delete();
        return $simcard;
    }

}
