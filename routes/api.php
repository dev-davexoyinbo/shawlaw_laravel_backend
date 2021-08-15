<?php

use App\Http\Controllers\API\AuthenticationController;
use App\Http\Controllers\API\PropertyController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post("/auth/register", [AuthenticationController::class, "register"])
    ->middleware(["auth:api", "role:ADMIN"]) // only admins can register a user
    ->name("auth.register.user");
Route::post("/auth/login", [AuthenticationController::class, "login"])->name("auth.login");
Route::get("/auth/me", [AuthenticationController::class, "me"])->name("auth.me");

Route::prefix("users")->middleware("auth:api")->group(function () {
    Route::post("/", [AuthenticationController::class, "register"]);
    Route::post("/update-user", [UserController::class, "update"]);
    Route::get("/{user}", [UserController::class, "show"])->withoutMiddleware("auth:api");
    Route::delete("/{user}", [UserController::class, "destroy"])->middleware(["permission:user_delete"]);
});

Route::prefix("properties")->middleware("auth:api")->group(function () {
    Route::post("/", [PropertyController::class, "store"])
        ->middleware("permission:property_create"); // authenticated user must have the property_create permission
    Route::get("/{property}", [PropertyController::class, "show"])->withoutMiddleware("auth:api");
    Route::post("/{property}", [PropertyController::class, "update"])
        ->middleware("permission:property_update"); // authenticated user must have the property_create permission
    Route::delete("/{property}", [PropertyController::class, "destroy"])
        ->middleware("permission:property_delete"); // authenticated user must have the property_delete permission
});
