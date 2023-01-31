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
    return view('top');
})->name('top');

Route::get('/entry', function () {
    return view('entry');
})->name('entry');

Route::get('/login', function () {
    return view('entry_login');
})->name('entry_login');

Route::get('/coming_soon', function () {
    return view('coming_soon');
})->name('coming_soon');

Route::get('inquiries', function() { return view('common.inquiries'); })->name('inquiries');

Route::prefix('admin')->group(function(){
    Route::match(['get', 'post'], 'login', 'AdministratorController@login')->name('admin.login');

    Route::middleware('auth:admin')->group(function(){
        Route::get('logout', 'AdministratorController@logout')->name('admin.logout');
        Route::get('administrator_list', function() { return view(config('const.template.admin.admin_list')); })->name('admin.list');
        Route::put('administrator_restore/{id}', 'AdministratorController@administrator_restore');
        Route::get('painter_list', function() { return view(config('const.template.admin.painter_list')); });
        Route::get('painters', 'AdministratorController@painters');
        Route::get('painter_detail', function() { return view(config('const.template.admin.painter_detail')); });
        Route::put('painter_approve/{id}', 'AdministratorController@painter_approve');
        Route::delete('painter_del/{id}', 'AdministratorController@painter_del');
        Route::put('painter_restore/{id}', 'AdministratorController@painter_restore');
        Route::get('user_list', function() { return view(config('const.template.admin.user_list')); });
        Route::get('users', 'AdministratorController@users');
        Route::get('user_detail', function() { return view(config('const.template.admin.user_detail')); });
        Route::delete('user_del/{id}', 'AdministratorController@user_del');
        Route::put('user_restore/{id}', 'AdministratorController@user_restore');
        Route::get('column_list', function() { return view(config('const.template.admin.column_list')); });
        Route::get('columns', 'AdministratorController@columns');
        Route::get('column_detail', function() { return view(config('const.template.admin.column_detail')); });
        Route::delete('column_del/{id}', 'AdministratorController@column_del');
        Route::get('example_list', function() { return view(config('const.template.admin.example_list')); });
        Route::get('examples', 'AdministratorController@examples');
        Route::get('example_detail', function() { return view(config('const.template.admin.example_detail')); });
        Route::delete('example_del/{id}', 'AdministratorController@example_del');
        Route::get('evaluation_list', function() { return view(config('const.template.admin.evaluation_list')); });
        Route::get('evaluations', 'AdministratorController@evaluations');
        Route::get('notice_list', function() { return view(config('const.template.admin.notice_list')); });
    });
});

Route::prefix('user')->group(function(){
    Route::match(['get', 'post'], 'login', 'User\UserController@login')->name('user.login');
    Route::get('mypage', 'User\UserController@show')->name('user.mypage');
    Route::get('logout', 'User\UserController@logout')->name('user.logout');
    Route::get('entry', 'User\UserController@create')->name('user.entry');
    Route::get('entry/complete', function() { return view(config('const.template.user.complete')); })->name('user.complete');
    Route::get('profile', 'User\UserController@edit')->name('user.edit');
    Route::put('edit', 'User\UserController@update')->name('user.update');
    Route::get('withdraw', 'User\UserController@withdraw')->name('user.withdraw');
    Route::get('detail/{id}', 'User\UserController@detail')->name('user.detail');

    Route::prefix('painter')->group(function(){
        Route::match(['get', 'post'], '/', 'User\PainterController@index')->name('user.painter');
        Route::get('search', 'User\PainterController@search')->name('user.painter.search');
        Route::get('favorite', 'User\PainterController@favorite')->name('user.painter.favorite');
        Route::get('/{id}', 'User\PainterController@show')->where('id', '[0-9]+')->name('user.painter.show');
    });

    Route::prefix('example')->group(function(){
        Route::get('/', 'User\ExampleController@index')->name('user.example');
        Route::get('painter/{id}', 'User\ExampleController@painter')->name('user.example.painter');
        Route::get('/{id}', 'User\ExampleController@show')->name('user.example.show');
    });

    Route::prefix('column')->group(function(){
        Route::get('/', 'User\ColumnController@index')->name('user.column');
        Route::get('painter/{id}', 'User\ColumnController@painter')->name('user.column.painter');
        Route::get('/{id}', 'User\ColumnController@show')->name('user.column.show');
    });

    Route::prefix('chat')->group(function(){
        Route::get('/', 'User\ChatThreadController@index')->name('user.chat');
        Route::get('create/{id}', 'User\ChatThreadController@create')->name('user.chat.create');
        Route::get('/{id}', 'User\ChatThreadController@show')->name('user.chat.show');
    });

    Route::middleware('auth:user')->group(function(){
        Route::get('inquiries', function() { return view('user.inquiries'); })->name('user.inquiries');
        Route::get('setting', function() { return view('user.setting'); })->name('user.setting');
        Route::get('update_password', function() { return view('user.update_password'); })->name('user.update_password');
    });
});

Route::prefix('painter')->group(function(){
    Route::match(['get', 'post'], 'login', 'Painter\PainterController@login')->name('painter.login');
    Route::get('mypage', 'Painter\PainterController@show')->name('painter.mypage');
    Route::get('logout', 'Painter\PainterController@logout')->name('painter.logout');
    Route::get('entry', 'Painter\PainterController@create')->name('painter.entry');
    Route::get('entry/complete', function() { return view(config('const.template.painter.complete')); })->name('painter.complete');
    Route::get('profile', 'Painter\PainterController@edit')->name('painter.edit');
    Route::put('edit', 'Painter\PainterController@update')->name('painter.update');
    Route::get('preview', 'Painter\PainterController@preview')->name('painter.preview');
    Route::get('withdraw', 'Painter\PainterController@withdraw')->name('painter.withdraw');
    Route::post('find', 'Painter\PainterController@find')->name('painter.find');
    Route::get('detail/{id}', 'Painter\PainterController@detail')->name('painter.detail');

    Route::prefix('example')->group(function(){
        Route::get('/', 'Painter\ExampleController@index')->name('painter.example');
        Route::get('create', 'Painter\ExampleController@create')->name('painter.example.create');
        Route::get('edit/{id}', 'Painter\ExampleController@edit')->name('painter.example.edit');
    });

    Route::prefix('column')->group(function(){
        Route::get('/', 'Painter\ColumnController@index')->name('painter.column');
        Route::get('create', 'Painter\ColumnController@create')->name('painter.column.create');
        Route::get('edit/{id}', 'Painter\ColumnController@edit')->name('painter.column.edit');
    });

    Route::prefix('chat')->group(function(){
        Route::get('/', 'Painter\ChatThreadController@index')->name('painter.chat');
        Route::get('/{id}', 'Painter\ChatThreadController@show')->name('painter.chat.show');
    });

    Route::middleware('auth:painter')->group(function(){
        Route::get('inquiries', function() { return view('painter.inquiries'); })->name('painter.inquiries');
        Route::get('setting', function() { return view('painter.setting'); })->name('painter.setting');
        Route::get('update_password', function() { return view('painter.update_password'); })->name('painter.update_password');
    });
});

/*
Route::prefix('example')->group(function(){
    Route::get('publish/{id}', 'ExampleController@publish')->name('example.publish');
    Route::get('list', 'ExampleController@list')->name('example.list');
});

Route::prefix('column')->group(function(){
    Route::get('list', 'ColumnController@list')->name('column.list');
    Route::get('create', 'ColumnController@create')->name('column.create');
});

Route::prefix('evaluation')->group(function(){
    Route::get('list', 'ExampleController@list')->name('evaluation.list');
});
*/

Route::prefix('password')->group(function(){
    Route::get('reset/{arg}', 'Auth\ForgotPasswordController@showLinkRequestForm')->where('arg', 'users|painters')->name('password.request');
    Route::post('email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('reset/{arg}/{token}', 'Auth\ResetPasswordController@showResetForm')->where('arg', 'users|painters')->name('password.reset');
    Route::post('reset', 'Auth\ResetPasswordController@reset')->name('password.update');
});

Route::post('notice/send', 'NoticeController@send');

Route::resources([
    'admin'      => 'AdministratorController',
    'notice'     => 'NoticeController',

    /*
    'column'     => 'ColumnController',
    'contract'   => 'ContractController',
    'evaluation' => 'EvaluationController',
    'favorite'   => 'FavoriteController',
    'property'   => 'PropertyController',
    'proposal'   => 'ProposalController',
    'request'    => 'RequestController',
    */
]);
