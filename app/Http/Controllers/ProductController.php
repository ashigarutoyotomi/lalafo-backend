<?php

namespace App\Http\Controllers;

use App\Actions\ProductAction;
use App\Gateways\ProductGateway;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $gateway = new ProductGateway();

        $keywords = $request->get('keywords');
        if ($keywords) {
            $gateway->setSearch($keywords, ['id']);
        }

        $filters = json_decode($request->get('filters'), true);
        if ($filters) {
            $gateway->setFilters($filters);
        }

        $gateway->paginate(20);

        return $gateway->all();
    }

    public function show(int $productId)
    {
        $product = Product::find($productId);
        abort_unless((bool) $product, 404, 'Product not found');

        $gateway = new ProductGateway();
        $gateway->with('creator');

        return $gateway->getById($productId);
    }

    public function getRandomProducts()
    {
        $gateway = new ProductGateway();
        $products = $gateway->getRandomProducts();

        return $products;
    }

    public function store(CreateProductRequest $request)
    {
        $data = ($request);

        return (new ProductAction)->create($data);
    }

    public function delete(int $productId)
    {
        $product = Product::find($productId);
        abort_unless((bool) $product, 404, 'sim card not found');

        $product->delete();
        return $product;
    }
}
