
<?php

use App\Http\Controllers\PostCommentController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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

Route::post('/login', [UserController::class, 'login']);
Route::post('/register', [UserController::class, 'register']);
Route::post('/create-moderator', [UserController::class, 'createModerator'])
    ->middleware(['auth:api', 'admin']);

Route::post('/post', [PostController::class, 'store'])->middleware(['auth:api']);;
Route::delete('/post/{id}', [PostController::class, 'destroy'])
    ->middleware(['auth:api', 'moderator_and_admin']);
Route::post('/posts/post_id/translate', [PostController::class, 'translate']);
Route::post('/posts/{postId}/edit/{languageCode}', [PostController::class, 'edit']);
Route::get('/posts/{languageKey}', [PostController::class, 'getPosts']);

Route::post('/postComment', [PostCommentController::class, 'store']);

Route::post('/blockUser', [UserController::class, 'blockUser'])
    ->middleware(['auth:api', 'admin']);



