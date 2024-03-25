<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, int $id)
    {
        try {
            DB::beginTransaction();
            $user = User::findOrFail($id);

            if ($request->name != null) {
                $user->name = $request->input('name');
            }
            if ($request->password != null) {
                $user->password = Hash::make($request->input('password'));
            }

            $user->save();
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
        return $user;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        try {
            DB::beginTransaction();
            $user = User::findOrFail($id);
            $user->delete();
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
        return response('Deleted successfully', 204);
    }
    public function me()
    {
        $user = auth()->user();

        return ['user' => $user,
            'products' => $user->products];
    }
    public function myProducts()
    {
        $user = User::find(auth()->user()
                ->id);
            $products = $user->products;
            return $products;
        }
    }
