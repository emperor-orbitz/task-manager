<?php
use Illuminate\Support\Facades\Route;


// Route::middleware(['auth','isUser'])->group(function () {
    Route::get('/user/dashboard', ['as'=>'user.dashboard', 'uses'=>'MemberController@dashboard']);
 
    Route::get('/user/department/{id}',[ 'as'=>'user.department.show', 'uses'=>'DepartmentController@showUser' ]);
    Route::get('/user/task/view/{task_connection_id}',['as'=>'user.task.view', 'uses'=>'MemberController@viewTask' ]);
    Route::post('/user/task/edit',['as'=>'user.task.edit', 'uses'=>'TaskController@userEdit' ]);
    // Route::post('/user/task/edit',[ 'as'=>'supervisor.task.edit', 'uses'=>'TaskController@userEdit' ]);
    Route::get('/user/task/draft/{task_id}', ['as'=>'supervisor.task.draft', 'uses'=>'TimelineController@draft' ]);

// });
