<?php

namespace App\Http\Controllers;

use App\Actions\SubcategoryAction;
use App\Gateways\SubcategoryGateway;
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

        $gateway->paginate(20);

        return $gateway->all();
    }

    public function show(int $subcategoryId)
    {
        $subcategory = Subcategory::find($subcategoryId);
        abort_unless((bool) $subcategory, 404, 'Subcategory not found');

        $gateway = new SubcategoryGateway();
        $gateway->with('user');

        return $gateway->getById($subcategoryId);
    }
    public function store(CreateSubcategoryRequest $request)
    {

        return (new SubcategoryAction)->create($request);
    }

    public function delete(int $subcategoryId)
    {
        $subcategory = SubcategoryAction::delete($subcategoryId);

        return $subcategory;
    }
}
