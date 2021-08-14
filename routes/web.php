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

Route::middleware(['auth','isAdmin'])->group(__DIR__.'/web/admin.route.php');

Route::middleware(['auth','isSupervisor'])->group(__DIR__.'/web/supervisor.route.php');
Route::middleware(['auth','isUser'])->group(__DIR__.'/web/user.route.php');




