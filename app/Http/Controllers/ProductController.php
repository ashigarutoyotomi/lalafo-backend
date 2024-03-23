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
            $gateway->setSearch($keywords, $request->get('columns'));
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
        $gateway->with('user');

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

        return (new ProductAction)->create($request);
    }

    public function delete(int $productId)
    {
        $product = ProductAction::delete($productId);

        return $product;
    }
}
