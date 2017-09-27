<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function (\Illuminate\Http\Request $request) {
    $user = $request->user();
    return response()->json(\App\User::where('id', $user->id)->with('repositories')->firstOrFail());
})->middleware('auth');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
