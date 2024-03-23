<?php

namespace App\Http\Controllers;

use App\Http\Actions\CategoryAction;
use App\Http\Gateways\CategoryGateway;
use App\Http\Requests\CreateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $gateway = new CategoryGateway();

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

    public function show(int $categoryId)
    {
        $category = Category::find($categoryId);
        abort_unless((bool) $category, 404, 'Category not found');

        $gateway = new CategoryGateway();
        $gateway->with('subcategories');

        return $gateway->getById($categoryId);
    }
    public function store(CreateCategoryRequest $request)
    {

        return (new CategoryAction)->create($request);
    }

    public function destroy(int $categoryId)
    {
        $category = CategoryAction::delete($categoryId);

        return $category;
    }
    public function update(Request $request, int $categoryId)
    {
        $category = (new CategoryAction)->update($request, $categoryId);

        return $category;
    }
}
