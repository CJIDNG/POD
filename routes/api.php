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

  // Agency routes...
  Route::get('/agencies', 'AgencyController@index');
  Route::get('/agencies/{id?}', 'AgencyController@show');
  Route::post('/agencies/{id}', 'AgencyController@store')
    ->middleware(['auth:api', 'permission:create_agencies|update_agencies']);
  Route::delete('/agencies/{id}', 'AgencyController@destroy')
    ->middleware(['auth:api', 'permission:delete_agencies']);

  // Government Project routes...
  Route::get('/governmentProjects', 'GovernmentProjectController@index');
  Route::get('/governmentProjects/{id?}', 'GovernmentProjectController@show');
  Route::post('/governmentProjects/{id}', 'GovernmentProjectController@store')
    ->middleware(['auth:api', 'permission:create_government_projects|update_government_projects']);
  Route::delete('/governmentProjects/{id}', 'GovernmentProjectController@destroy')
    ->middleware(['auth:api', 'permission:delete_government_projects']);

  // Local Government routes...
  Route::get('/localGovernments', 'LocalGovernmentController@index');
  Route::get('/localGovernments/{id?}', 'LocalGovernmentController@show');
  Route::post('/localGovernments/{id}', 'LocalGovernmentController@store')
    ->middleware(['auth:api', 'permission:create_localGovernments|update_localGovernments']);
  Route::delete('/localGovernments/{id}', 'LocalGovernmentController@destroy')
    ->middleware(['auth:api', 'permission:delete_localGovernments']);

  // Ministry routes...
  Route::get('/ministries', 'MinistryController@index');
  Route::get('/ministries/{id?}', 'MinistryController@show');
  Route::post('/ministries/{id}', 'MinistryController@store')
    ->middleware(['auth:api', 'permission:create_ministries|update_ministries']);
  Route::delete('/ministries/{id}', 'MinistryController@destroy')
    ->middleware(['auth:api', 'permission:delete_ministries']);

  // State routes...
  Route::get('/states', 'StateController@index');
  Route::get('/states/{id?}', 'StateController@show');
  Route::post('/states/{id}', 'StateController@store')
    ->middleware(['auth:api', 'permission:create_states|update_states']);
  Route::delete('/states/{id}', 'StateController@destroy')
    ->middleware(['auth:api', 'permission:delete_states']);

  // Status routes...
  Route::get('/statuses', 'StatusController@index');
  Route::get('/statuses/{id?}', 'StatusController@show');
  Route::post('/statuses/{id}', 'StatusController@store')
    ->middleware(['auth:api', 'permission:create_statuses|update_statuses']);
  Route::delete('/statuses/{id}', 'StatusController@destroy')
    ->middleware(['auth:api', 'permission:delete_statuses']);

  // Type routes...
  Route::get('/types', 'TypeController@index');
  Route::get('/types/{id?}', 'TypeController@show');
  Route::post('/types/{id}', 'TypeController@store')
    ->middleware(['auth:api', 'permission:create_types|update_types']);
  Route::delete('/types/{id}', 'TypeController@destroy')
    ->middleware(['auth:api', 'permission:delete_types']);

  // Health Facility routes...
  Route::get('/health-facilities', 'HealthFacilityController@index');
  Route::get('/health-facilities/{id?}', 'HealthFacilityController@show');
  Route::post('/health-facilities/{id}', 'HealthFacilityController@store')
    ->middleware(['auth:api', 'permission:create_health_facilities|update_health_facilities']);
  Route::delete('/health-facilities/{id}', 'HealthFacilityController@destroy')
    ->middleware(['auth:api', 'permission:delete_health_facilities']);

  // Incident routes...
  Route::get('/incidents', 'IncidentController@index');
  Route::get('/incidents/{id?}', 'IncidentController@show');
  Route::post('/incidents/{id}', 'IncidentController@store')
    ->middleware(['auth:api', 'permission:create_incidents|update_incidents']);
  Route::delete('/incidents/{id}', 'IncidentController@destroy')
    ->middleware(['auth:api', 'permission:delete_incidents']);

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

  // Data resource routes...
  Route::get('/datatopics', 'DatatopicController@index');
  Route::get('/datatopics/{id?}', 'DatatopicController@show');
  Route::post('/datatopics/{id}', 'DatatopicController@store')
    ->middleware(['auth:api', 'permission:create_datatopics|update_datatopics']);
  Route::delete('/datatopics/{id}', 'DatatopicController@destroy')
    ->middleware(['auth:api', 'permission:delete_datatopics']);

  // Media routes...
  Route::post('/resource/uploads', 'DataResourceUploadController@store')
    ->middleware(['auth:api', 'role:Admin|Data Curator|Data Researcher & Editor']);
  Route::delete('/resource/uploads', 'DataResourceUploadController@destroy')
    ->middleware(['auth:api', 'role:Admin|Data Curator|Data Researcher & Editor']);

  Route::group(['prefix' => 'blog'], function () {
    Route::get('/', 'BlogController@index')->name('blog.index');
    Route::middleware('throttle:60,1')->get('/view/{slug}', 'BlogController@post')->name('blog.post');
  });

  Route::group(['prefix' => 'data'], function () {
    Route::get('/', 'DatasetController@indexPublishedOnly')->name('data.index');
    Route::middleware('throttle:60,1')->get('/{id}', 'DatasetController@showPublishedOnly')->name('data.show');
  });
});
