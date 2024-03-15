<?php

use App\Http\Controllers\API\V1\PostController;
use App\Http\Controllers\API\V1\CommentController;
use Illuminate\Support\Facades\Route;

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


// The Auth routes are in auth.php

Route::apiResource("post", PostController::class)->middleware("loggedIn");
Route::apiResource("comment", CommentController::class)->only(["store" , "update" , "destroy"])->middleware("loggedIn");

