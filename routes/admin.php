<?php

use Illuminate\Support\Facades\Route;
use http\Env\Request;
/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function() {

    Route::group(['namespace' => 'Dashboard', 'middleware' => 'auth:admin', 'prefix' => 'admin'], function () {

        Route::get('/', 'DashboardController@index')->name('admin.dashboard'); //the first page admin visit's if authenticated

        Route::get('logout', 'LoginController@logout') -> name('admin.logout');

        Route::group(['prefix' => 'Settings'], function () {
            Route::get('shipping-methods/{type}', 'SettingsController@editShippingMethods')->name('edit.shipping.methods');
            Route::put('shipping-methods/{id}', 'SettingsController@updateShippingMethods')->name('update.shipping.methods');

        });


        Route::group(['prefix' => 'profile'], function () {
            Route::get('edit', 'ProfileController@editProfile')->name('edit.profile');
            Route::put('update', 'ProfileController@updateProfile')->name('update.profile');
            //Route::put('update/password', 'ProfileController@updatePassword')->name('update.profile.password');

        });
      ################################## categories routes #################################################
       Route::group(['prefix' => 'main_categories'], function (){
           Route::get('/', 'MainCategoriesController@index') -> name('admin.maincategories');
           Route::get('create', 'MainCategoriesController@create') -> name('admin.maincategories.create');
           Route::post('store', 'MainCategoriesController@store') -> name('admin.maincategories.store');
           Route::get('edit/{id}', 'MainCategoriesController@edit') -> name('admin.maincategories.edit');
           Route::put('update/{id}', 'MainCategoriesController@update') -> name('admin.maincategories.update');
           Route::get('delete/{id}', 'MainCategoriesController@destroy') -> name('admin.maincategories.delete');
           Route::get('changeStatus/{id}', 'MainCategoriesController@changeStatus') -> name('admin.maincategories.status');
       });
        ################################### end categories routes ##################################################


        ################################### subcategories routes ##################################################
        Route::group(['prefix' => 'sub_categories'], function (){
            Route::get('/', 'SubCategoriesController@index') -> name('admin.subcategories');
            Route::get('create', 'SubCategoriesController@create') -> name('admin.subcategories.create');
            Route::post('store', 'SubCategoriesController@store') -> name('admin.subcategories.store');
            Route::get('edit/{id}', 'SubCategoriesController@edit') -> name('admin.subcategories.edit');
            Route::put('update/{id}', 'SubCategoriesController@update') -> name('admin.subcategories.update');
            Route::get('delete/{id}', 'SubCategoriesController@destroy') -> name('admin.subcategories.delete');
            Route::get('changeStatus/{id}', 'SubCategoriesController@changeStatus') -> name('admin.subcategories.status');
        });
        ################################### end subcategories routes ##################################################

        ################################### brands routes ##################################################
        Route::group(['prefix' => 'brands'], function (){
            Route::get('/', 'brandsController@index') -> name('admin.brands');
            Route::get('create', 'brandsController@create') -> name('admin.brands.create');
            Route::post('store', 'brandsController@store') -> name('admin.brands.store');
            Route::get('edit/{id}', 'brandsController@edit') -> name('admin.brands.edit');
            Route::put('update/{id}', 'brandsController@update') -> name('admin.brands.update');
            Route::get('delete/{id}', 'brandsController@destroy') -> name('admin.brands.delete');
            Route::get('changeStatus/{id}', 'brandsController@changeStatus') -> name('admin.brands.status');
        });
        ################################### end brands routes ##################################################



    });


    Route::group(['namespace' => 'Dashboard', 'middleware' => 'guest:admin', 'prefix' => 'admin'], function () {

        Route::get('login', 'LoginController@login')->name('admin.login');

        Route::post('login', 'LoginController@postLogin')->name('admin.post.login');

    });

});
