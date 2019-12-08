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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', 'PostController@index')->name('index');

// Route Post
Route::middleware('auth')->group(function() {
	Route::get('/post/create', 'PostController@create')->name('post.create');
	Route::post('/post/create', 'PostController@store')->name('post.store');
	// Route::get('/post/{id}/edit', 'PostController@edit')->name('post.edit');
	// Route::post('/post/{id}/edit', 'PostController@update')->name('post.update');
	// Route::post('/post/{id}/destroy', 'PostController@destroy')->name('post.destroy');

	Route::get('/post/{slug}/edit', 'PostController@edit')->name('post.edit');
	Route::post('/post/{slug}/edit', 'PostController@update')->name('post.update');
	Route::post('/post/{slug}/destroy', 'PostController@destroy')->name('post.destroy');
});

Route::get('/post/{slug}', 'PostController@show')->name('post.show');

Route::resource('category', 'CategoryController');

Auth::routes();
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

Route::get('/home', 'HomeController@index')->name('home');
