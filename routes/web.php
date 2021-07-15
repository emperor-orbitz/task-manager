<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', ['as'=>"welcome", 'uses'=> 'IndexController@welcome'] );
Route::get('/login',[ 'as' =>'login', 'uses'=> 'IndexController@login']);
Route::get('/register',[ 'as'=>'register', 'uses'=>'IndexController@register' ]);
Route::get('/logout',[ 'as'=>'logout', 'uses'=>'UserController@logout' ]);
Route::post('/login/submit',[ 'as' =>'login.user', 'uses'=> 'UserController@loginUser']);
Route::post('/register/submit',[ 'as'=>'register.user', 'uses'=>'UserController@registerUser' ]);
// Route::get('/task/t',[ 'as'=>'department.show', 'uses'=>'AdminController@show' ]);




Route::middleware(['auth','isAdmin'])->group(function () {
    Route::get('/admin/dashboard', ['as'=>'admin.dashboard', 'uses'=>'AdminController@dashboard']);
    Route::get('/admin/tasks', ['as'=>'admin.tasks', 'uses'=>'AdminController@tasks']);
    Route::get('/admin/department/create',[ 'as'=>'admin.department.create', 'uses'=>'DepartmentController@create' ]);
    Route::post('/admin/department/store',[ 'as'=>'admin.department.store', 'uses'=>'DepartmentController@store' ]);
    Route::get('/admin/department/{id}',[ 'as'=>'admin.department.show', 'uses'=>'DepartmentController@show' ]);
    Route::post('/admin/task/store',[ 'as'=>'admin.task.store', 'uses'=>'TaskController@store' ]);

    Route::post('/admin/connection/store',[ 'as'=>'admin.connection.store', 'uses'=>'AdminController@storeConnection' ]);
    Route::get('/admin/task/view/{task_id}',['as'=>'supervisor.task.view', 'uses'=>'AdminController@viewTask' ]);
    Route::post('/admin/task/edit',[ 'as'=>'admin.task.edit', 'uses'=>'TaskController@adminEdit' ]);

    Route::get('/admin/task/delete/{id}',[ 'as'=>'admin.task.delete', 'uses'=>'AdminController@deleteTask' ]);
    Route::get('/admin/task/create',['as'=>'admin.task.create', 'uses'=>'TaskController@create' ]);
    Route::get('/admin/user',['as'=>'admin.user', 'uses'=>'AdminController@newUser' ]);
    Route::post('/admin/user/create',['as'=>'admin.user.create', 'uses'=>'AdminController@createUser' ]);
    Route::get('/admin/user/delete/{id}',['as'=>'admin.user.delete', 'uses'=>'AdminController@deleteUser' ]);
    Route::get('/admin/task/draft/{task_id}',[ 'as'=>'admin.task.draft', 'uses'=>'TimelineController@draft' ]);
    Route::get('/admin/user/remove/{connection_id}',['as'=>'admin.user.remove', 'uses'=>'SupervisorController@removeUserFromDepartment' ]);

});

Route::middleware(['auth','isSupervisor'])->group(function () {
    Route::get('/supervisor/dashboard', ['as'=>'supervisor.dashboard', 'uses'=>'SupervisorController@dashboard']);
 
    Route::get('/supervisor/department/{id}',[ 'as'=>'supervisor.department.show', 'uses'=>'DepartmentController@showSupervisor' ]);
    Route::post('/supervisor/task/store',[ 'as'=>'supervisor.task.store', 'uses'=>'TaskController@supervisorStore' ]);
    Route::post('/supervisor/connection/store',[ 'as'=>'supervisor.connection.store', 'uses'=>'SupervisorController@storeConnection' ]);
    Route::get('/supervisor/task/delete/{id}',[ 'as'=>'supervisor.task.delete', 'uses'=>'SupervisorController@deleteTask' ]);
    Route::get('/supervisor/task/create',['as'=>'supervisor.task.create', 'uses'=>'TaskController@supervisorCreate' ]);
    Route::get('/supervisor/user',['as'=>'supervisor.user', 'uses'=>'SupervisorController@newUser' ]);
    Route::post('/supervisor/user/create',['as'=>'supervisor.user.create', 'uses'=>'SupervisorController@createUser' ]);
    Route::get('/supervisor/user/remove/{connection_id}',['as'=>'supervisor.user.remove', 'uses'=>'SupervisorController@removeUserFromDepartment' ]);
    Route::get('/supervisor/task/view/{task_id}',['as'=>'supervisor.task.view', 'uses'=>'SupervisorController@viewTask' ]);
    Route::post('/supervisor/task/edit',[ 'as'=>'supervisor.task.edit', 'uses'=>'TaskController@supervisorEdit' ]);
    Route::get('/supervisor/task/draft/{task_id}',[ 'as'=>'supervisor.task.draft', 'uses'=>'TimelineController@draft' ]);



});


Route::middleware(['auth','isUser'])->group(function () {
    Route::get('/user/dashboard', ['as'=>'user.dashboard', 'uses'=>'MemberController@dashboard']);
 
    Route::get('/user/department/{id}',[ 'as'=>'user.department.show', 'uses'=>'DepartmentController@showUser' ]);
    // Route::post('/supervisor/task/store',[ 'as'=>'supervisor.task.store', 'uses'=>'TaskController@supervisorStore' ]);
    // Route::post('/supervisor/connection/store',[ 'as'=>'supervisor.connection.store', 'uses'=>'SupervisorController@storeConnection' ]);
    // Route::get('/supervisor/task/delete/{id}',[ 'as'=>'supervisor.task.delete', 'uses'=>'SupervisorController@deleteTask' ]);
    // Route::get('/supervisor/task/create',['as'=>'supervisor.task.create', 'uses'=>'TaskController@supervisorCreate' ]);
    // Route::get('/supervisor/user',['as'=>'supervisor.user', 'uses'=>'SupervisorController@newUser' ]);
    // Route::post('/supervisor/user/create',['as'=>'supervisor.user.create', 'uses'=>'SupervisorController@createUser' ]);
    // Route::get('/supervisor/user/remove/{connection_id}',['as'=>'supervisor.user.remove', 'uses'=>'SupervisorController@removeUserFromDepartment' ]);
    Route::get('/user/task/view/{task_id}',['as'=>'user.task.view', 'uses'=>'MemberController@viewTask' ]);
    Route::post('/user/task/edit',[ 'as'=>'user.task.edit', 'uses'=>'TaskController@userEdit' ]);
    // Route::post('/user/task/edit',[ 'as'=>'supervisor.task.edit', 'uses'=>'TaskController@userEdit' ]);
    Route::get('/user/task/draft/{task_id}',[ 'as'=>'supervisor.task.draft', 'uses'=>'TimelineController@draft' ]);

});
