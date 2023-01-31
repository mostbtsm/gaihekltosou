<?php

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

Route::prefix('stub')->group(function () {
    Route::prefix('top')->group(function () {
        Route::post('painters', 'Stub\TopController@painters');
        Route::post('exsamples', 'Stub\TopController@exsamples');
        Route::post('columns', 'Stub\TopController@columns');
    });

    Route::prefix('user')->group(function(){
        Route::post('/', 'Stub\UserController@entry');
        Route::post('login', 'Stub\UserController@login');
    });

    Route::prefix('painter')->group(function(){
        Route::post('/', 'Stub\PainterController@entry');
        Route::post('login', 'Stub\PainterController@login');
    });

    Route::prefix('config')->group(function(){
        Route::post('select', 'Stub\ConfigController@select');
    });

    Route::prefix('column')->group(function(){
        Route::post('store', 'Stub\ColumnController@store');
    });
});

Route::prefix('v1')->group(function () {
    Route::post('inquiry', 'V1\InquiryController@index');

    Route::get('config', 'V1\ConfigController');

    Route::prefix('user')->group(function(){
        Route::post('/', 'V1\User\UserController@entry');
        Route::post('login', 'V1\User\UserController@login');
    });

    Route::prefix('painter')->group(function(){
        Route::post('/', 'V1\Painter\PainterController@entry');
        Route::post('login', 'V1\Painter\PainterController@login');
    });
});

Route::match(['get', 'post'], 'contact', 'ContactController@contact');
