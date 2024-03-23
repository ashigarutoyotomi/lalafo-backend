<?php

namespace App\Actions;

use Exception;
use Illuminate\Support\Facades\DB;

class SubcategoryAction
{
    public function create($request)
    {
        try {
            DB::beginTransaction();
            $subcategory = new Subcategory;
            $subcategory->name = $request->name;
            $subcategory->category_id = $request->category_id;
            $subcategory->save();
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
        return $subcategory;
    }

    public function update($data)
    {$subcategory = (new SubcategoryGateway)->getById($data->id);
        try {
            DB::beginTransaction();

            abort_unless((bool) $subcategory, 404, "Subsubcategory not found");
            $subcategory->name = $data->name;
            $subcategory->subcategory_id = $data->subcategory_id;
            $subcategory->save();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
        return $subcategory;}

    public static function delete(int $subcategoryId)
    {
        try {
            DB::beginTransaction();
            $subcategory = (new SubcategoryGateway)->getById($subcategoryId);
            abort_unless((bool) $subcategory, 404, "Subsubcategory not found");
            $subcategory->delete();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
        return $subcategory;
    }

}
