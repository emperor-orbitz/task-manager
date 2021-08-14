<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\UserController;
use App\Connection;
use App\Task;
use App\TaskConnections;
use App\User;
use App\Timeline;
use Illuminate\Support\Facades\Hash;
use Throwable;

// use App\Http\Controllers\TaskController;

class AdminController extends Controller

{
    //
    public function dashboard(Request $request)
    {
        $results = DepartmentController::getAll();
        $users = UserController::getAll();
        return view('admin.dashboard', ['departments' => $results, 'users' => $users]);
    }

    public function deleteTask(Request $request, $id)
    {
        //delete a task with its id
        $delete = TaskConnections::where('id', '=', $id)->delete();
        if ($delete) {
            self::setStatus($request, ['status' => 'success', 'message' => 'Task Deletion Successful']);
            return redirect()->back();
        } else {
            self::setStatus($request, ['status' => 'error', 'message' => 'Oops! I was unable to help you delete this']);
            return redirect()->back();
        }
    }


    public function createUser(Request $request)
    {

        $data = $request->only(['first_name', 'last_name', 'email', 'password', 'role']);
        try {
            $create = User::create($data);
            if ($create) {
                return self::setStatusAndRedirect($request, ['status' => 'success', 'message' => 'User successfuly created by you']);
            }
        } catch (\Throwable $th) {
            //throw $th;
            return self::setStatusAndRedirect($request, ['status' => 'error', 'message' => 'Oops! I was unable to help you create this']);
        }
    }

    public function deleteUser(Request $request, $id)
    {

        $data = $request->only(['first_name', 'last_name', 'email', 'password', 'role']);
        $where = ['id', '=', $id];
        try {
            $delete = User::where('id', '=', $id)->delete();
            if ($delete) {
                return self::setStatusAndRedirect($request, ['status' => 'success', 'message' => 'User successfuly created by you']);
            }
        } catch (\Throwable $th) {
            //throw $th;
            return self::setStatusAndRedirect($request, ['status' => 'error', 'message' => 'Oops! I was unable to help you create this']);
        }
    }


    public function newUser(Request $request)
    {
        return view('admin.new_user');
    }

    public function storeConnection(Request $request)
    {
        $data = $request->only(['department_id', 'user_id']);
        $store_data = Connection::where($data);
        if ($store_data->count() > 0) {

            self::setStatus($request, ['status' => 'error', 'message' => 'Oops! Seems he/she is part of this department']);
            return redirect()->back();
        } else {
            $store_data = Connection::create($data);
            self::setStatus($request, ['status' => 'success', 'message' => 'User Added to Department Successfully']);
            return redirect()->back();
        }
    }


    public function viewTask(Request $request, $task_connection_id)
    {
        try {

            $task = TaskConnections::where('task_connections.id', '=', $task_connection_id)
                                    ->join('tasks', 'task_connections.task_id' ,'=', 'tasks.id')
                                    
                                    ->select('tasks.id', 'tasks.title', 'tasks.description', 'tasks.created_at', 'tasks.updated_at')
                                    ->get()->first();

            $timelines = Timeline::where(['task_connection_id' => $task_connection_id])
                // ->join('users', 'timelines.user_id', '=', 'users.id')

                // ->select('users.id AS user_id', 'timelines.id', 'users.email', 'task_updates', 'users.first_name', 'task_id', 'task_updates', 'timelines.updated_at', 'progress', 'timelines.notes')
                ->orderBy('created_at', 'desc')
                ->get();
            // dd($task_connection_id,$task, $timelines);
            return view('admin.view_task', ['task' => $task, 'timelines' => $timelines]);
        } catch (\Throwable $th) {
            // abort(500);
            throw $th;
        }

        // dd($task, $timeline);

    }

    public function editUserPage(Request $request, $id)
    {
        //Find User with ID and return Form
        try {
            $user = User::where('id', '=', $id)->get()->first();
            return view('admin.edit_user', ['data' => $user]);
        } catch (Throwable $th) {
            abort(500);
        }
    }


    public function editUser(Request $request)
    {
        //Find User with ID and return Form
        try {
            // $user = User::where('id', '=', $id)->get()->first();
 
            $id = $request->input('id');
            $data = $request->only(['email', 'first_name', 'last_name', 'role']);
            $user = User::where('id', '=', $id)
                ->update($data);
            return self::setStatusAndRedirect($request,  ['status' => 'success', 'message' => 'User Details Updated Successfully']);

        } catch (Throwable $th) {
            abort(500);
        }
    }

    public function editPassword(Request $request)
    {
        //Find User with ID and return Form
        try {
 
            $id = $request->input('id');
            $password = Hash::make($request->input('password'));
            
            $user = User::where('id', '=', $id)
                ->update(['password'=>$password]);

            $request->session()->flash('password_status', "success");
            $request->session()->flash('password_message',"Password Successfuly Updated for User");
            return redirect()->back();

        } catch (Throwable $th) {
            abort(500);
        }
    }


    private static function setStatusAndRedirect($request, $data)
    {

        $request->session()->flash('status', $data['status']);
        $request->session()->flash('message', $data['message']);
        return redirect()->back();
    }

    private static function setStatus($request, $data)
    {

        $request->session()->flash('status', $data['status']);
        $request->session()->flash('message', $data['message']);
    }
}
