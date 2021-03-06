<?php

Route::get('/', 'HomeController@getIndex');

// authentication
Route::get('login', ['as' => 'login', 'uses' => 'AuthController@getLogin']);
Route::get('login-required', 'AuthController@getLoginRequired');
Route::get('signup-confirm', 'AuthController@getSignupConfirm');
Route::post('signup-confirm', 'AuthController@postSignupConfirm');
Route::get('logout', 'AuthController@getLogout');
Route::get('oauth', 'AuthController@getOauth');

// user dashboard
Route::get('dashboard', ['before' => 'auth', 'uses' => 'DashboardController@getIndex']);
Route::get('dashboard/articles', ['before' => 'auth', 'uses' => 'ArticlesController@getDashboard']);

// user profile
Route::get('user/{userSlug}', 'UsersController@getProfile');

// chat
Route::get('contributors', 'ContributorsController@getIndex');

// chat
Route::get('chat', 'ChatController@getIndex');

// pastes
Route::get('bin', 'PastesController@getCreate');

// articles
Route::get('articles', 'ArticlesController@getIndex');
Route::get('article/{slug}/edit-comment/{commentId}', ['before' => 'auth|handle_slug', 'uses' => 'ArticlesController@getEditComment']);
Route::post('article/{slug}/edit-comment/{commentId}', ['before' => 'auth|handle_slug', 'uses' => 'ArticlesController@postEditComment']);
Route::get('article/{slug}/delete-comment/{commentId}', ['before' => 'auth|handle_slug', 'uses' => 'ArticlesController@getDeleteComment']);
Route::post('article/{slug}/delete-comment/{commentId}', ['before' => 'auth|handle_slug', 'uses' => 'ArticlesController@postDeleteComment']);
Route::get('article/{slug}', ['before' => 'handle_slug', 'uses' => 'ArticlesController@getShow']);
Route::post('article/{slug}', ['before' => 'handle_slug', 'uses' => 'ArticlesController@postShow']);
Route::get('articles/compose', ['before' => 'auth', 'uses' => 'ArticlesController@getCompose']);
Route::post('articles/compose', ['before' => 'auth', 'uses' => 'ArticlesController@postCompose']);
Route::get('articles/edit/{article}', ['before' => 'auth', 'uses' => 'ArticlesController@getEdit']);
Route::post('articles/edit/{article}', ['before' => 'auth', 'uses' => 'ArticlesController@postEdit']);
Route::get('articles/search', 'ArticlesController@getSearch');

// forum
Route::get('forum', 'ForumThreadController@getIndex');
Route::get('forum/search', 'ForumThreadController@getSearch');

// move to new controller
Route::get('forum/{slug}/comment/{commentId}', 'ForumReplyController@getCommentRedirect');

Route::group(['before' => 'auth'], function() {
    Route::get('forum/create-thread', 'ForumThreadController@getCreateThread');
    Route::post('forum/create-thread', 'ForumThreadController@postCreateThread');
    Route::get('forum/edit-thread/{threadId}', 'ForumThreadController@getEditThread');
    Route::post('forum/edit-thread/{threadId}', 'ForumThreadController@postEditThread');
    Route::get('forum/edit-reply/{replyId}', 'ForumReplyController@getEditReply');
    Route::post('forum/edit-reply/{replyId}', 'ForumReplyController@postEditReply');

    Route::get('forum/delete/thread/{threadId}', 'ForumThreadController@getDelete');
    Route::post('forum/delete/thread/{threadId}', 'ForumThreadController@postDelete');
    Route::get('forum/delete/reply/{replyId}', 'ForumReplyController@getDelete');
    Route::post('forum/delete/reply/{replyId}', 'ForumReplyController@postDelete');

    Route::post('forum/{slug}', ['before' => 'handle_slug', 'uses' => 'ForumReplyController@postCreateReply']);
});

Route::get('forum/{slug}', ['before' => 'handle_slug', 'uses' => 'ForumThreadController@getShowThread']);

// admin
Route::group(['before' => 'auth', 'prefix' => 'admin'], function() {

    Route::get('/', function() {
        return Redirect::action('Admin\UsersController@getIndex');
    });

	// users
    Route::group(['before' => 'has_role:admin_users'], function() {
    	Route::get('users', 'Admin\UsersController@getIndex');
        Route::get('edit/{user}', 'Admin\UsersController@getEdit');
        Route::post('edit/{user}', 'Admin\UsersController@postEdit');
    });
});
