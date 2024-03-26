<?php

namespace App\Http\Controllers;

use App\Http\Actions\ProductAction;
use App\Http\Controllers\Controller;
use App\Http\Gateways\ProductGateway;
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
        $randomProducts = Product::where('activated', true)->inRandomOrder()->limit(50)->with('favorites')->with('subcategory')->get();
        return $randomProducts;
    }

    public function store(CreateProductRequest $request)
    {
        return (new ProductAction)->create($request);
    }

    public function destroy(int $productId)
    {
        $product = ProductAction::destroy($productId);

        return response('Deleted successfully', 204);
    }
    public function update(Request $request, int $productId)
    {
        $product = (new ProductAction)->update($request, $productId);

        return $product;
    }
    public function switch(Request $request, int $productId)
    {
            $product = (new ProductAction)->switch($productId);

            return $product;
    }
}
