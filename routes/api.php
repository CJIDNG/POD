<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/
Route::group(['prefix' => 'v1'], function () {
  // Stats routes...
  Route::get('/stats', 'StatsController@index')->middleware(['auth:api']);
  Route::get('/stats/{id}', 'StatsController@show')->middleware(['auth:api']);

  // Post routes...
  Route::get('/posts', 'PostController@index')
    ->middleware(['auth:api', 'permission:view_posts']);
  Route::get('/posts/{id?}', 'PostController@show')
    ->middleware(['auth:api', 'permission:view_posts|view_own_posts']);
  Route::post('/posts/{id}', 'PostController@store')
    ->middleware(['auth:api', 'permission:create_posts|update_posts|update_own_posts|approve_posts|publish_posts']);
  Route::delete('/posts/{id}', 'PostController@destroy')
    ->middleware(['auth:api', 'permission:delete_posts|delete_own_posts']);

  // Tag routes...
  Route::get('/tags', 'TagController@index')->middleware(['auth:api', 'tenancy.enforce']);
  Route::get('/tags/{id?}', 'TagController@show')->middleware(['auth:api', 'tenancy.enforce']);
  Route::post('/tags/{id}', 'TagController@store')->middleware(['auth:api', 'tenancy.enforce']);
  Route::delete('/tags/{id}', 'TagController@destroy')->middleware(['auth:api', 'tenancy.enforce']);

  // Topic routes...
  Route::get('/topics', 'TopicController@index')->middleware(['auth:api', 'tenancy.enforce']);
  Route::get('/topics/{id?}', 'TopicController@show')->middleware(['auth:api', 'tenancy.enforce']);
  Route::post('/topics/{id}', 'TopicController@store')->middleware(['auth:api', 'tenancy.enforce']);
  Route::delete('/topics/{id}', 'TopicController@destroy')->middleware(['auth:api', 'tenancy.enforce']);

  // User routes...
  Route::get('/users', 'UserController@index')
    ->middleware(['auth:api', 'permission:view_users']);
  Route::get('/users/{id?}', 'UserController@show')
    ->middleware(['auth:api', 'permission:view_users|view_own_users']);
  Route::post('/users/{id}', 'UserController@store')
    ->middleware(['auth:api', 'permission:create_users|update_users|update_own_users']);
  Route::delete('/users/{id}', 'UserController@destroy')
    ->middleware(['auth:api', 'permission:delete_users']);

  // Platform routes...
  Route::get('/platforms', 'PlatformController@index')
    ->middleware(['auth:api', 'role:Admin']);
  Route::get('/platforms/{id?}', 'PlatformController@show')
    ->middleware(['auth:api', 'role:Admin']);
  Route::post('/platforms/{id}', 'PlatformController@store')
    ->middleware(['auth:api', 'role:Admin']);
  Route::delete('/platforms/{id}', 'PlatformController@destroy')
    ->middleware(['auth:api', 'role:Admin']);

  // Media routes...
  Route::post('/media/uploads', 'MediaController@store')
    ->middleware(['auth:api', 'role:Admin|Writer|Editor']);
  Route::delete('/media/uploads', 'MediaController@destroy')
    ->middleware(['auth:api', 'role:Admin|Writer|Editor']);

  // Settings routes...
  Route::get('/settings', 'SettingsController@show')
    ->middleware(['auth:api', 'tenancy.enforce']);
  Route::post('/settings', 'SettingsController@update')
    ->middleware(['auth:api', 'tenancy.enforce']);

  Route::prefix('locale')->group(function () {
    Route::post('/', 'LocaleController@update');
  });

  // Role routes...
  Route::get('/roles', 'RoleController@index')
    ->middleware(['auth:api', 'permission:view_roles']);
  Route::get('/roles/{id?}', 'RoleController@show')
    ->middleware(['auth:api', 'permission:view_roles']);
  Route::post('/roles/{id}', 'RoleController@store')
    ->middleware(['auth:api', 'permission:create_roles|update_roles', 'tenancy.enforce']);
  Route::delete('/roles/{id}', 'RoleController@destroy')
    ->middleware(['auth:api', 'permission:delete_roles']);

  // Permission routes...
  Route::get('/permissions', function () {
    return response()->json(\App\Permission::all()->pluck('name'));
  })->middleware(['auth:api', 'role:Admin']);

  // Dataset routes...
  Route::get('/datasets', 'DatasetController@index')
    ->middleware(['auth:api', 'permission:view_datasets']);
  Route::get('/datasets/{id?}', 'DatasetController@show')
    ->middleware(['auth:api', 'permission:view_datasets|view_own_datasets']);
  Route::post('/datasets/{id}', 'DatasetController@store')
    ->middleware(['auth:api', 'permission:create_datasets|update_datasets|update_own_datasets|approve_datasets|publish_datasets']);
  Route::delete('/datasets/{id}', 'DatasetController@destroy')
    ->middleware(['auth:api', 'permission:delete_datasets|delete_own_datasets']);

  // Data resource routes...
  Route::get('/dataresources', 'DataresourceController@index');
  Route::get('/dataresources/{id?}', 'DataresourceController@show');
  Route::post('/dataresources/{id}', 'DataresourceController@store')
    ->middleware(['auth:api', 'permission:create_datasets|update_datasets|update_own_datasets|approve_datasets|publish_datasets']);
  Route::delete('/dataresources/{id}', 'DataresourceController@destroy')
    ->middleware(['auth:api', 'permission:delete_datasets|delete_own_datasets']);
  Route::get('/dataresources/download/{id}', 'DataresourceController@download')
    ->middleware(['auth:api']);

  // Data format routes...
  Route::get('/dataformats', 'DataformatController@index');
  Route::get('/dataformats/{id?}', 'DataformatController@show');
  Route::post('/dataformats/{id}', 'DataformatController@store')
    ->middleware(['auth:api', 'permission:create_dataformats|update_dataformats']);
  Route::delete('/dataformats/{id}', 'DataformatController@destroy')
    ->middleware(['auth:api', 'permission:delete_dataformats']);

  // Data license routes...
  Route::get('/datalicenses', 'DatalicenseController@index');
  Route::get('/datalicenses/{id?}', 'DatalicenseController@show');
  Route::post('/datalicenses/{id}', 'DatalicenseController@store')
    ->middleware(['auth:api', 'permission:create_datalicenses|update_datalicenses']);
  Route::delete('/datalicenses/{id}', 'DatalicenseController@destroy')
    ->middleware(['auth:api', 'permission:delete_datalicenses']);

  // Data topics routes...
  Route::get('/datatopics', 'DatatopicController@index');
  Route::get('/datatopics/{id?}', 'DatatopicController@show');
  Route::post('/datatopics/{id}', 'DatatopicController@store')
    ->middleware(['auth:api', 'permission:create_datatopics|update_datatopics']);
  Route::delete('/datatopics/{id}', 'DatatopicController@destroy')
    ->middleware(['auth:api', 'permission:delete_datatopics']);

  // Partners routes...
  Route::get('/partners', 'PartnerController@index');
  Route::get('/partners/{id?}', 'PartnerController@show');
  Route::post('/partners/{id}', 'PartnerController@store')
    ->middleware(['auth:api', 'permission:create_partners']);
  Route::delete('/partners/{id}', 'PartnerController@destroy')
    ->middleware(['auth:api', 'permission:delete_partners']);

  // designations routes...
  Route::get('/designations', 'DesignationController@index');
  Route::get('/designations/{id?}', 'DesignationController@show');
  Route::post('/designations/{id}', 'DesignationController@store')
    ->middleware(['auth:api', 'permission:create_designations']);
  Route::delete('/designations/{id}', 'DesignationController@destroy')
    ->middleware(['auth:api', 'permission:delete_designations']);

  // members routes...
  Route::get('/members', 'MemberController@index');
  Route::get('/members/{id?}', 'MemberController@show');
  Route::post('/members/{id}', 'MemberController@store')
    ->middleware(['auth:api', 'permission:create_designations']);
  Route::delete('/members/{id}', 'MemberController@destroy')
    ->middleware(['auth:api', 'permission:delete_designations']);

  // services routes...
  Route::get('/services', 'ServiceController@index');
  Route::get('/services/{id?}', 'ServiceController@show');
  Route::post('/services/{id}', 'ServiceController@store')
    ->middleware(['auth:api', 'permission:create_services']);
  Route::delete('/services/{id}', 'ServiceController@destroy')
    ->middleware(['auth:api', 'permission:delete_services']);

  // trackers routes...
  Route::get('/trackers', 'TrackerController@index');
  Route::get('/trackers/{id?}', 'TrackerController@show');
  Route::post('/trackers/{id}', 'TrackerController@store')
    ->middleware(['auth:api', 'permission:create_trackers']);
  Route::delete('/trackers/{id}', 'TrackerController@destroy')
    ->middleware(['auth:api', 'permission:delete_trackers']);

  // trackerItems routes...
  Route::get('/trackerItems/{trackerId}', 'TrackerItemController@index');
  Route::get('/trackerItems/{trackerId}/{id?}', 'TrackerItemController@show');
  Route::post('/trackerItems/{trackerId}/{id}', 'TrackerItemController@store')
    ->middleware(['auth:api', 'permission:create_tracker_items|update_tracker_items']);
  Route::delete('/trackerItems/{trackerId}/{id}', 'TrackerItemController@destroy')
    ->middleware(['auth:api', 'permission:delete_tracker_items']);

  // comments routes...
  Route::get('/comments', 'CommentController@index');
  Route::delete('/comments/{commentableType}/{id}', 'CommentController@destroy')
    ->middleware(['auth:api', 'permission:delete_comments']);

  // Media routes...
  Route::post('/resource/uploads', 'DataResourceUploadController@store')
    ->middleware(['auth:api', 'role:Admin|Data Curator|Data Researcher & Editor']);
  Route::delete('/resource/uploads', 'DataResourceUploadController@destroy')
    ->middleware(['auth:api', 'role:Admin|Data Curator|Data Researcher & Editor']);

  // Route::group(['prefix' => 'blog'], function () {
  //   Route::get('/', 'BlogController@index')->name('blog.index');
  //   Route::middleware('throttle:60,1')->get('/view/{slug}', 'BlogController@post')->name('blog.post');
  // });

  Route::namespace('Blog')->prefix('blog')->group(function () {
    Route::prefix('posts')->group(function () {
      Route::get('/', 'PostController@index');
      Route::get('{identifier}/{slug}', 'PostController@show'); //->middleware('Canvas\Http\Middleware\Session')
    });

    Route::prefix('tags')->group(function () {
      Route::get('/', 'TagController@index');
      Route::get('{slug}', 'TagController@show');
    });

    Route::prefix('topics')->group(function () {
      Route::get('/', 'TopicController@index');
      Route::get('{slug}', 'TopicController@show');
    });

    Route::prefix('users')->group(function () {
      Route::get('{identifier}', 'UserController@show');
    });
  });

  Route::group(['prefix' => 'data'], function () {
    Route::get('/', 'DatasetController@indexPublishedOnly')->name('data.index');
    Route::middleware('throttle:60,1')->get('/{id}', 'DatasetController@showPublishedOnly')->name('data.show');
  });
});
