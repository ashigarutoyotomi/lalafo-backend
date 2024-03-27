<?php
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FavoritesController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductPhotoController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserNotificationController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [RegisterController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [RegisterController::class, 'logout']);

    // Categories CRUD
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::get('/categories/{id}', [CategoryController::class, 'show']);
    Route::put('/categories/{id}', [CategoryController::class, 'update']);
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);

    // Subcategories CRUD
    Route::get('/subcategories', [SubcategoryController::class, 'index']);
    Route::post('/subcategories', [SubcategoryController::class, 'store']);
    Route::get('/subcategories/{id}', [SubcategoryController::class, 'show']);
    Route::put('/subcategories/{id}', [SubcategoryController::class, 'update']);
    Route::delete('/subcategories/{id}', [SubcategoryController::class, 'destroy']);

    // Products CRUD
    Route::get('/products', [ProductController::class, 'index']);
    Route::post('/products', [ProductController::class, 'store']);
    Route::post('/products/{id}/switch', [ProductController::class, 'switch']);
    Route::get('/products/random-products', [ProductController::class, 'getRandomProducts']);
    Route::get('/products/{id}', [ProductController::class, 'show']);
    Route::put('/products/{id}', [ProductController::class, 'update']);
    Route::delete('/products/{id}', [ProductController::class, 'destroy']);

    // User Notifications CRUD? dont know how to use it here
    Route::get('/user-notifications', [UserNotificationController::class, 'index']);
    Route::post('/user-notifications', [UserNotificationController::class, 'store']);
    Route::delete('/user-notifications/{id}', [UserNotificationController::class, 'destroy']);
    // User CRUD
    Route::get('/users/me', [UserController::class, 'me']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);
    Route::get('/users/products', [UserController::class, 'myProducts']);

    Route::get('/favorites', [FavoritesController::class, 'index']);
    Route::post('/favorites/{id}/favorite', [FavoritesController::class, 'favorite']);
    Route::post('/favorites/{id}/unfavorite', [FavoritesController::class, 'unfavorite']);

    // Product photo CRUD
    Route::get('/product-photos', [ProductPhotoController::class, 'index']);
    Route::post('/product-photos', [ProductPhotoController::class, 'store']);
    Route::delete('/product-photos/{id}', [ProductPhotoController::class, 'destroy']);
});
