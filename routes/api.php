<?php

use App\Http\Controllers\api\coursePrice\CoursesPriceController;
use App\Http\Controllers\api\favorites\FavoritesController;
use App\Http\Controllers\api\logo\LogoController;
use App\Http\Controllers\api\meta\MetaController;
use App\Http\Controllers\api\ratings\RatingsController;
use App\Http\Controllers\api\sentence\sentenceCategoryController;
use App\Http\Controllers\api\sentence\SentenceController;
use App\Http\Controllers\api\termsRules\TermsRulesController;
use App\Http\Controllers\api\users\UsersController;
use App\Http\Controllers\api\words\WordsCategoryController;
use App\Http\Controllers\api\words\WordsController;
use App\Http\Controllers\api\words\wordsUpdate;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// words
Route::apiResource("wordsCategory", WordsCategoryController::class);
Route::apiResource("words", WordsController::class);
Route::post('words/{id}', [WordsController::class, "wordsUpdate"]);

// sentence
Route::apiResource("sentencesCategory", SentenceCategoryController::class);
Route::apiResource("sentences", SentenceController::class);
Route::post('sentences/{id}', [SentenceController::class, "update"]);


// users
Route::apiResource("users", UsersController::class);

// favorites
Route::apiResource("favorites", FavoritesController::class);

// ratings
Route::apiResource("ratings", RatingsController::class);

// courses price
Route::apiResource("coursePrice", CoursesPriceController::class);

// logo
Route::apiResource("logo", LogoController::class);
Route::post('logo/{id}', [LogoController::class, "update"]);


// termsRules
Route::apiResource("termsRules", TermsRulesController::class);

// meta
Route::apiResource("meta", MetaController::class);
