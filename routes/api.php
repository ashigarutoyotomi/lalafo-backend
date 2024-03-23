<?php
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\UserNotificationController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [RegisterController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [RegisterController::class, 'logout']);

    // Categories CRUD
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::get('/categories/{category}', [CategoryController::class, 'show']);
    Route::put('/categories/{category}', [CategoryController::class, 'update']);
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);

    // Subcategories CRUD
    Route::get('/subcategories', [SubcategoryController::class, 'index']);
    Route::post('/subcategories', [SubcategoryController::class, 'store']);
    Route::get('/subcategories/{subcategory}', [SubcategoryController::class, 'show']);
    Route::put('/subcategories/{subcategory}', [SubcategoryController::class, 'update']);
    Route::delete('/subcategories/{subcategory}', [SubcategoryController::class, 'destroy']);

    // Products CRUD
    Route::get('/products', [ProductController::class, 'index']);
    Route::post('/products', [ProductController::class, 'store']);
    Route::get('/products/{product}', [ProductController::class, 'show']);
    Route::put('/products/{product}', [ProductController::class, 'update']);
    Route::delete('/products/{product}', [ProductController::class, 'destroy']);

    // User Notifications CRUD
    Route::get('/user-notifications', [UserNotificationController::class, 'index']);
    Route::post('/user-notifications', [UserNotificationController::class, 'store']);
    Route::get('/user-notifications/{notification}', [UserNotificationController::class, 'show']);
    Route::put('/user-notifications/{notification}', [UserNotificationController::class, 'update']);
    Route::delete('/user-notifications/{notification}', [UserNotificationController::class, 'destroy']);
});
