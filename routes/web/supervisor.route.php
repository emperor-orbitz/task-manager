<?php
use Illuminate\Support\Facades\Route;


    Route::get('/supervisor/dashboard', ['as'=>'supervisor.dashboard', 'uses'=>'SupervisorController@dashboard']);
 
    Route::get('/supervisor/department/{id}',[ 'as'=>'supervisor.department.show', 'uses'=>'DepartmentController@showSupervisor' ]);
    Route::post('/supervisor/task/store',[ 'as'=>'supervisor.task.store', 'uses'=>'TaskController@supervisorStore' ]);
    Route::post('/supervisor/connection/store',[ 'as'=>'supervisor.connection.store', 'uses'=>'SupervisorController@storeConnection' ]);
    Route::get('/supervisor/task/delete/{id}',[ 'as'=>'supervisor.task.delete', 'uses'=>'SupervisorController@deleteTask' ]);
    Route::get('/supervisor/task/create',['as'=>'supervisor.task.create', 'uses'=>'TaskController@supervisorCreate' ]);
    Route::get('/supervisor/user',['as'=>'supervisor.user', 'uses'=>'SupervisorController@newUser' ]);
    Route::post('/supervisor/user/create',['as'=>'supervisor.user.create', 'uses'=>'SupervisorController@createUser' ]);
    Route::get('/supervisor/user/remove/{connection_id}',['as'=>'supervisor.user.remove', 'uses'=>'SupervisorController@removeUserFromDepartment' ]);
    // Route::get('/supervisor/task/view/{task_id}',['as'=>'supervisor.task.view', 'uses'=>'SupervisorController@viewTask' ]);
    Route::post('/supervisor/task/edit',[ 'as'=>'supervisor.task.edit', 'uses'=>'TaskController@supervisorEdit' ]);
    Route::get('/supervisor/task/draft/{task_id}',[ 'as'=>'supervisor.task.draft', 'uses'=>'TimelineController@draft' ]);
    Route::get('/supervisor/user/task/{user_id}',['as'=>'supervisor.user.task', 'uses'=>'TaskController@superviorViewTask' ]);

    Route::get('/supervisor/task/view/{task_connection_id}',['as'=>'supervisor.task.view', 'uses'=>'SupervisorController@viewTask' ]);
    Route::post('/supervisor/user/task/create',['as'=>'supervisor.user.task.create', 'uses'=>'TaskController@addTaskToUser' ]);

    Route::get('/supervisor/task/delete/{id}',[ 'as'=>'admin.task.delete', 'uses'=>'SupervisorController@deleteTask' ]);

