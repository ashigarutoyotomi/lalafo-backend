<?php

namespace App\Http\Controllers;

use App\Http\Actions\SubcategoryAction;
use App\Http\Gateways\SubcategoryGateway;
use App\Http\Requests\CreateSubcategoryRequest;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
    public function index(Request $request)
    {
        $gateway = new SubcategoryGateway();

        $keywords = $request->get('keywords');
        if ($keywords) {
            $gateway->setSearch($keywords, $request->get('columns'));
        }

        $filters = json_decode($request->get('filters'), true);
        if ($filters) {
            $gateway->setFilters($filters);
        }
        // $gateway->paginate(20);

        return $gateway->all();
    }

    public function show(int $subcategoryId)
    {
        $subcategory = Subcategory::find($subcategoryId);
        abort_unless((bool) $subcategory, 404, 'Subcategory not found');

        $gateway = new SubcategoryGateway();
        // $gateway->with('category');
        $gateway->with('products');
        return $gateway->getById($subcategoryId);
    }
    public function store(CreateSubcategoryRequest $request)
    {

        return (new SubcategoryAction)->create($request);
    }

    public function destroy(int $subcategoryId)
    {
        $subcategory = SubcategoryAction::delete($subcategoryId);

        return response('Deleted successfully', 204);
    }
    public function update(Request $request, int $subcategoryId)
    {
        $subcategory = (new SubcategoryAction)->update($request, $subcategoryId);

        return $subcategory;
    }
    public function getByCategoryId(Request $request, int $subcategoryId)
    {
        $subcategories = Subcategory::where('category_id', $subcategoryId)->get();
        return $subcategories;
    }
}
