<?php


use App\Http\Middleware\LocaleMiddleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
    return view('auth.login');
});

Auth::routes();

Route::group(['middleware' => 'auth', 'prefix' => LocaleMiddleware::getLocale()], function () {
    Route::get('/section', 'SectionController@index')->name('section_index');
    Route::get('/section/create', 'SectionController@create')->name('section_create');
    Route::get('/section/update/{id}', 'SectionController@edit')->name('section_update');
    Route::get('/section/delete/{id}', 'SectionController@delete')->name('section_delete');

    Route::get('/user', 'UserController@index')->name('user_index');
    Route::get('/user/create', 'UserController@create')->name('user_create');
    Route::get('/user/update/{id}', 'UserController@edit')->name('user_update');
    Route::get('/user/delete/{id}', 'UserController@delete')->name('user_delete');
});
