<?php

use App\Http\Controllers\Auth\ProductController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\HomeController;

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
    return redirect()->to('/login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/dropzone', 'HomeController@index')->name('file-upload');

Route::middleware('auth')->group(function () {
    Route::resource('product-variant', 'VariantController');
    Route::resource('product', 'ProductController');
    Route::resource('blog', 'BlogController');
    Route::resource('blog-category', 'BlogCategoryController');

    Route::post('/product','ProductController@store')->name('sendData');
    Route::get('/product.index','ProductController@index')->name('display');
    Route::get('/products/{id}/edit', 'ProductController@edit');
    Route::put('/products/{id}', 'ProductController@update')->name('products.update');


  
    
});
