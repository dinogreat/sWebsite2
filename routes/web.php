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
Route::resource('post', 'PostController');
Route::get('/', 'PagesController@index');
Route::get('/services', 'PagesController@services');
Route::get('/about', 'PagesController@about');
// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('contact', function(){
	return 'HELLO FROM CONTACT';
});

Route::get('contact/members', function(){
	return 'HELLO FROM members';
});

Route::get('contact/{category}', function($category){

return 'HELLO FROM' . $category;

});

Auth::routes();

Route::get('/dashboard', 'DashboardController@index');
