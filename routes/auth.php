<?php

use App\Http\Controllers\API\V1\Auth\AuthController;
use App\Http\Controllers\API\V1\Auth\SocialiteController;
use Illuminate\Support\Facades\Route;

Route::post("/register", [AuthController::class, "register"]);
Route::post("/login", [AuthController::class, "login"]);
Route::get("/provider/{platform}", [SocialiteController::class, "loginWithProvider"])->where('platform', 'facebook|google');
Route::get("/google-callback", [SocialiteController::class, "googleCallback"]);
Route::get("/facebook-callback", [SocialiteController::class, "facebookCallback"]);
Route::get("/logout", [AuthController::class, "logout"])->middleware("loggedIn");
Route::get("/logout-all", [AuthController::class, "logoutAllDevices"])->middleware("loggedIn");
;
