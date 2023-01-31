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
    Route::prefix('user')->group(function () {
        Route::get('show', 'Stub\UserController@show');
        Route::post('update', 'Stub\UserController@update');
        Route::post('upload_image', 'Stub\UserController@uploadImage');
        Route::post('delete_image', 'Stub\UserController@deleteImage');
        Route::get('properties', 'Stub\UserController@properties');
        Route::get('search', 'Stub\UserController@search');
        Route::get('examplelist', 'Stub\UserController@examplelist');
        Route::post('evaluationupdate', 'Stub\UserController@evaluationupdate');
        Route::get('painterprofileimage', 'Stub\UserController@painterprofileimage');
        Route::get('painterimages', 'Stub\UserController@painterimages');
        Route::get('painterimageurl', 'Stub\UserController@painterimageurl');
        Route::get('exampleimageurl', 'Stub\UserController@exampleimageurl');
        Route::get('getevaluation', 'Stub\UserController@getevaluation');
        Route::get('getevaluationcount', 'Stub\UserController@getevaluationcount');
        Route::get('favorite', 'Stub\UserController@favorite');
        Route::get('addfavorite', 'Stub\UserController@addfavorite');
        Route::get('deletefavorite', 'Stub\UserController@deletefavorite');
        Route::post('inquiry', 'Stub\UserController@inquiry');
        Route::post('update_password', 'Stub\UserController@updatePassword');
        Route::post('withdraw', 'Stub\UserController@withdraw');
        Route::get('getcolumn', 'Stub\UserController@getcolumn');
    });

    Route::prefix('property')->group(function () {
        Route::post('store', 'Stub\PropertyController@store');
        Route::post('update/{id}', 'Stub\PropertyController@update');
        Route::post('destroy/{id}', 'Stub\PropertyController@destroy');
    });

    Route::prefix('painter')->group(function () {
        Route::get('show', 'Stub\PainterController@show');
        Route::post('update', 'Stub\PainterController@update');
        Route::post('upload_image', 'Stub\PainterController@uploadImage');
        Route::post('delete_image', 'Stub\PainterController@deleteImage');
        Route::post('store', 'Stub\PainterController@store');
        Route::get('images', 'Stub\PainterController@images');
        Route::get('imageurl', 'Stub\PainterController@imageurl');
        Route::post('exampleentry', 'Stub\PainterController@exampleentry');
        Route::post('inquiry', 'Stub\PainterController@inquiry');
        Route::post('update_password', 'Stub\PainterController@updatePassword');
        Route::post('withdraw', 'Stub\PainterController@withdraw');
        Route::post('columnstore', 'Stub\PainterController@columnstore');
        Route::get('getpainterinfo', 'Stub\PainterController@getpainterinfo');
        Route::get('getexampleentrylink', 'Stub\PainterController@getexampleentrylink');
        Route::get('getcolumnlink', 'Stub\PainterController@getcolumnlink');
        Route::get('examplelist', 'Stub\PainterController@examplelist');
        Route::post('exampleupload', 'Stub\PainterController@exampleupload');
        Route::get('deleteexample', 'Stub\PainterController@deleteexample');
        Route::get('getcolumn', 'Stub\PainterController@getcolumn');
        Route::post('columnupload', 'Stub\PainterController@columnupload');
        Route::get('deletecolumn', 'Stub\PainterController@deletecolumn');
        Route::get('getevaluation', 'Stub\UserController@getevaluation');
    });

});

Route::prefix('v1')->group(function () {
    Route::prefix('user')->group(function () {
        Route::get('show', 'V1\User\UserController@show');
        Route::post('update', 'V1\User\UserController@update');
        Route::post('upload_image', 'V1\User\UserController@uploadImage');

        Route::apiResource('favorite', 'V1\User\FavoriteController')->only(['index', 'store', 'destroy']);

        Route::prefix('painter')->group(function(){
            Route::get('favorite', 'V1\User\PainterController@favorite');
        });
        Route::apiResource('painter', 'V1\User\PainterController')->only(['index', 'show']);

        Route::apiResource('example', 'V1\User\ExampleController')->only(['index', 'show']);
        Route::prefix('example')->group(function(){
            Route::get('painter/{id}', 'V1\User\ExampleController@painter');
        });

        Route::apiResource('column', 'V1\User\ColumnController')->only(['index', 'show']);
        Route::prefix('column')->group(function(){
            Route::get('painter/{id}', 'V1\User\ColumnController@painter');
        });

        Route::apiResource('chat', 'V1\User\ChatThreadController')->only(['index', 'store']);

        Route::post('delete_image', 'V1\User\UserController@deleteImage');
        Route::get('properties', 'V1\User\UserController@properties');
        Route::get('search', 'V1\User\UserController@search');
        Route::get('examplelist', 'V1\User\UserController@examplelist');
        Route::post('evaluationupdate', 'V1\User\UserController@evaluationupdate');
        Route::get('painterprofileimage', 'V1\User\UserController@painterprofileimage');
        Route::get('painterimages', 'V1\User\UserController@painterimages');
        Route::get('painterimageurl', 'V1\User\UserController@painterimageurl');
        Route::get('exampleimageurl', 'V1\User\UserController@exampleimageurl');
        Route::get('getevaluation', 'V1\User\UserController@getevaluation');
        Route::get('getevaluationcount', 'V1\User\UserController@getevaluationcount');

        Route::get('addfavorite', 'V1\User\UserController@addfavorite');
        Route::get('deletefavorite', 'V1\User\UserController@deletefavorite');
        Route::post('inquiry', 'V1\User\UserController@inquiry');
        Route::post('update_password', 'V1\User\UserController@updatePassword');
        Route::post('withdraw', 'V1\User\UserController@withdraw');
        Route::get('getcolumn', 'V1\User\UserController@getcolumn');
    });

    Route::prefix('painter')->group(function () {
        Route::get('show', 'V1\Painter\PainterController@show');
        Route::post('update', 'V1\Painter\PainterController@update');
        Route::post('upload_image', 'V1\Painter\PainterController@uploadImage');


        Route::apiResource('column', 'V1\Painter\ColumnController');
        Route::apiResource('example', 'V1\Painter\ExampleController');
        Route::apiResource('chat', 'V1\Painter\ChatThreadController')->only(['index']);

        Route::get('images', 'V1\Painter\PainterController@images');
        Route::get('imageurl', 'V1\Painter\PainterController@imageurl');
        Route::post('exampleentry', 'V1\Painter\PainterController@exampleentry');
        Route::post('inquiry', 'V1\Painter\PainterController@inquiry');
        Route::post('update_password', 'V1\Painter\PainterController@updatePassword');
        Route::post('withdraw', 'V1\Painter\PainterController@withdraw');
        Route::post('columnstore', 'V1\Painter\PainterController@columnstore');
        Route::get('getpainterinfo', 'V1\Painter\PainterController@getpainterinfo');
        Route::get('getexampleentrylink', 'V1\Painter\PainterController@getexampleentrylink');
        Route::get('getcolumnlink', 'V1\Painter\PainterController@getcolumnlink');
        Route::get('examplelist', 'V1\Painter\PainterController@examplelist');
        Route::post('exampleupload', 'V1\Painter\PainterController@exampleupload');
        Route::get('deleteexample', 'V1\Painter\PainterController@deleteexample');
        Route::get('getcolumn', 'V1\Painter\PainterController@getcolumn');
        Route::post('columnupload', 'V1\Painter\PainterController@columnupload');
        Route::get('deletecolumn', 'V1\Painter\PainterController@deletecolumn');
    });

    Route::apiResource('chat', 'V1\ChatMessageController')->only(['index','store']);
});

Route::post('/message', 'MessageController@get')->name('message.get');
Route::put('/message', 'MessageController@store')->name('message.send');
Route::get('/pdf/{name}', 'MessageController@pdf')->name('message.pdf');
Route::get('/message/clear', 'MessageController@clear')->name('message.clear');

Route::match(['get', 'post', 'put'], 'estimate', 'WorkflowController@estimate');
Route::match(['get', 'post'], 'proposal', 'WorkflowController@proposal');
Route::get('/properties/{kbn}/{user_id}', 'WorkflowController@get_properties');
Route::get('/favorites/{user_id}', 'WorkflowController@get_favorites');
Route::get('/messages/{id}/{kbn}', 'WorkflowController@get_messages');

Route::get('/workflow/user', 'WorkflowController@workflow_u');
Route::get('/workflow/painter', 'WorkflowController@workflow_p');
Route::get('/negotiation/{id}', 'WorkflowController@negotiation');
Route::get('/contract/{id}', 'WorkflowController@contract');
Route::get('/finish/{id}', 'WorkflowController@finish');
Route::post('/complete', 'WorkflowController@complete');
