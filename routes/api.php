<?php
header("Access-Control-Allow-Origin: http://localhost");
header("Access-Control-Allow-Credentials: true");

use Illuminate\Http\Request;

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

/*Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');*/

//REQUEST ONLY WITH TOKEN
Route::group(['prefix' => 'v2'], function () {
    Route::group(['middleware'=> 'auth:api'], function (){
        route::get('upper/{word}', function ($word){
            return ['testv2'=> $word, 'upper'=> strtoupper($word)];
        });
    });
});