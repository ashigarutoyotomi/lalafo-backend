<?php

namespace App\Actions;

use App\Gateways\CategoryGateway;
use App\Models\Category;
use Exception;
use Illuminate\Support\Facades\DB;

class CategoryAction
{
    public function create($request)
    {
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
        abort_unless((bool) $category, 404, "Category not found");
        $category->name = $data->name;
        $category->save();
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
