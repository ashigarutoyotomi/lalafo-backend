<?php

namespace App\Http\Actions;

use App\Http\Gateways\SubcategoryGateway;
use App\Models\Subcategory;
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

    public function update($request, int $id)
    {$subcategory = (new SubcategoryGateway)->getById($id);
        try {
            DB::beginTransaction();

            abort_unless((bool) $subcategory, 404, "Subcategory not found");
            if ($request->name != null) {
                $subcategory->name = $request->name;
            }
            if ($request->category_id != null) {
                $subcategory->category_id = $request->category_id;
            }
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
