<?php

namespace App\Http\Actions;

use App\Http\Gateways\CategoryGateway;
use App\Models\Category;
use Exception;
use Illuminate\Support\Facades\DB;

class CategoryAction
{
    public function create($request)
    {
        $category = Category::where('name', $request->name)->first();
        if ($category != null) {
            abort(422, 'Category is already exists');
        }
        try {
            DB::beginTransaction();
            $category = new Category;
            $category->name = $request->name;

            $category->save();
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
        return $category;
    }

    public function update($data)
    {
        $category = (new CategoryGateway)->getById($data->id);
        try {
            DB::beginTransaction();

            abort_unless((bool) $category, 404, "Subcategory not found");
            if ($data->name != null) {
                $category->name = $data->name;
            }
            $category->save();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
        return $category;
    }

    public static function delete(int $categoryId)
    {
        try {
            DB::beginTransaction();
            $category = (new CategoryGateway)->getById($categoryId);
            abort_unless((bool) $category, 404, "Category not found");
            $category->delete();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
        return $category;
    }

}
