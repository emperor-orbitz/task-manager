<?php
use Illuminate\Support\Facades\Route;


    Route::get('/admin/dashboard', ['as'=>'admin.dashboard', 'uses'=>'AdminController@dashboard']);
    Route::get('/admin/tasks', ['as'=>'admin.tasks', 'uses'=>'AdminController@tasks']);
    Route::get('/admin/department/create',[ 'as'=>'admin.department.create', 'uses'=>'DepartmentController@create' ]);
    Route::post('/admin/department/store',[ 'as'=>'admin.department.store', 'uses'=>'DepartmentController@store' ]);
    Route::get('/admin/department/{id}',[ 'as'=>'admin.department.show', 'uses'=>'DepartmentController@show' ]);
    Route::post('/admin/task/store',[ 'as'=>'admin.task.store', 'uses'=>'TaskController@store' ]);

    Route::post('/admin/connection/store',[ 'as'=>'admin.connection.store', 'uses'=>'AdminController@storeConnection' ]);
    Route::post('/admin/task/edit',[ 'as'=>'admin.task.edit', 'uses'=>'TaskController@adminEdit' ]);

    Route::get('/admin/user/edit/{id}',['as'=>'admin.user.get.edit', 'uses'=>'AdminController@editUserPage' ]);
    Route::post('/admin/user/edit',['as'=>'admin.user.post.edit', 'uses'=>'AdminController@editUser' ]);
    Route::post('/admin/user/password/edit',['as'=>'admin.user.password.edit', 'uses'=>'AdminController@editPassword' ]);

    Route::get('/admin/user/task/{user_id}',['as'=>'admin.user.task', 'uses'=>'TaskController@viewTask' ]);
    

    Route::post('/admin/user/task/create',['as'=>'admin.user.task.create', 'uses'=>'TaskController@addTaskToUser' ]);
    Route::get('/admin/task/view/{task_connection_id}',['as'=>'supervisor.task.view', 'uses'=>'AdminController@viewTask' ]);

    Route::get('/admin/task/delete/{id}',[ 'as'=>'admin.task.delete', 'uses'=>'AdminController@deleteTask' ]);
    Route::get('/admin/task/create',['as'=>'admin.task.create', 'uses'=>'TaskController@create' ]);
    Route::get('/admin/user',['as'=>'admin.user', 'uses'=>'AdminController@newUser' ]);
    Route::post('/admin/user/create',['as'=>'admin.user.create', 'uses'=>'AdminController@createUser' ]);
    Route::get('/admin/user/delete/{id}',['as'=>'admin.user.delete', 'uses'=>'AdminController@deleteUser' ]);
    Route::get('/admin/task/draft/{task_id}',[ 'as'=>'admin.task.draft', 'uses'=>'TimelineController@draft' ]);
    Route::get('/admin/user/remove/{connection_id}',['as'=>'admin.user.remove', 'uses'=>'SupervisorController@removeUserFromDepartment' ]);

