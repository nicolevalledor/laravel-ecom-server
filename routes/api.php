<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ConcernController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


//Public routes
Route::get("/products", [ProductController::class,'index']);
Route::get("/products/{id}", [ProductController::class, 'show']);
Route::get("/products/search/{name}", [ProductController::class, 'search']);
Route:: post("/register", [AuthController::class, 'register']);
Route:: post("/login", [AuthController::class, 'login']);
Route::get("/category", [CategoryController::class, 'index']); //all category
Route::get("/concerns", [ConcernController::class, 'index']); //all record

Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::post("/logout", [AuthController::class, 'logout']);
    Route::get("/authUser", [AuthController::class, 'authUser']);
    Route::get("/carts", [CartController::class,'index']);
    Route::put('/orders/{id}', [OrderController::class, 'updateStatus']);
    Route::post("/carts", [CartController::class, 'store']);
    Route::delete("/carts/{id}", [CartController::class, 'destroy']);
    Route::put("/carts/{id}", [CartController::class, 'update']);
    Route::post("/orders", [OrderController::class, 'store']);
    Route::get("/orders", [OrderController::class, 'index']); //all record
});



//Admin Routes
//Protected routes
Route::group(['middleware' => ['auth:sanctum', 'role:admin']], function(){
    Route::get("/all_products", [ProductController::class,'allProduct']);
    Route::post("/products", [ProductController::class, 'store']);
    Route::put("/products/{id}", [ProductController::class, 'update']);
    Route::delete("/products/{id}", [ProductController::class, 'destroy']);

    Route::get("/all_orders", [OrderController::class, 'allOrder']); //all order

    Route::post("/category", [CategoryController::class, 'store']); //create category
    Route::get("/category/{id}", [CategoryController::class, 'show']); //specific category
    Route::put("/category/{id}", [CategoryController::class, 'update']); //update category
    Route::delete("/category/{id}", [CategoryController::class, 'destroy']); //delete category

    Route::post("/concerns", [ConcernController::class, 'store']);
    Route::get("/concerns/{id}", [ConcernController::class, 'show']); //specific record
    Route::put("/concerns/{id}", [ConcernController::class, 'update']);
    Route::delete("/concerns/{id}", [ConcernController::class, 'destroy']);

    Route::get("/dashboard", [DashboardController::class, 'index']); //Dashboard

    Route::get("/users", [AuthController::class, 'index']); //all users
});

