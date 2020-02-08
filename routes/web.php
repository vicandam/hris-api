<?php
Auth::routes();

Route::get('/', 'HomeController@index')->name('index');
Route::get('/home', 'HomeController@index')->name('home');
Route::post('/contact', 'InquiriesController@contact')->name('contact');

Route::resource('inquiries', 'InquiriesController');

Route::get('/{page?}', 'HomeController@index')->name('feed-stackoverflow');


// api
Route::group(['prefix' => 'api' ], function(){
    Route::group(['prefix' => 'post'], function(){
        Route::post('search', 'PostController@search')->name('api.post.search');
        Route::post('{post_id?}/update', 'PostController@update')->name('api.post.update');
        Route::post('{post_id?}/delete', 'PostController@delete')->name('api.post.delete');
        Route::post('store', 'PostController@store')->name('api.post.store');
    });

    Route::group(['prefix' => 'user'], function(){
        Route::group(['prefix' => 'profile'], function(){
            Route::post('load', 'UserController@profileLoad')->name('api.profile.update');
            Route::post('update', 'UserController@profileUpdate')->name('api.profile.update');
            Route::post('update/photo', 'UserController@profileUpdatePhoto')->name('api.profile.update.photo');
        });
    });

    Route::group(['prefix' => 'message1'], function() {
        Route::post('contact1', 'MessageController@store')->name('api.message.store');
    });

    Route::group(['prefix' => 'message'], function(){

        Route::post('feedback', 'MessageController@store')->name('api.feedback.post');
        Route::post('feedback/search', 'MessageController@search')->name('api.feedback.search');
        Route::post('feedback/{message_id?}/delete', 'MessageController@delete')->name('api.feedback.delete');
    });

    Route::group(['prefix' => 'external'], function(){
        Route::post('stackoverflow-question-and-answer', 'StackExchangeController@stackoveflowQuestionAndAnswer')->name('api.get.stackexchange-stackoveflow-question-and-answer');
        Route::post('git/repositories', 'GitController@getRepositories')->name('api.get.repositories');
    });
});
