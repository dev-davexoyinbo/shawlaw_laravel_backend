<?php

use App\Http\Controllers\API\AuthenticationController;
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

Route::post("/auth/register", [AuthenticationController::class, "register"])->name("auth.register.user");
Route::post("/auth/login", [AuthenticationController::class, "login"])->name("auth.login");
Route::get("/auth/me", [AuthenticationController::class, "me"])->name("auth.me");

Route::prefix("users")->group(function () {
    Route::post("/", [AuthenticationController::class, "register"]);
});
