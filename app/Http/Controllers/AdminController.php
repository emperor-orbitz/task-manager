<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\UserController;
use App\Connection;
use App\Task;
use App\User;
use App\Timeline;

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
        $delete = Task::where('id', '=', $id)->delete();
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
        $where =['id', '=', $id];
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


    public function viewTask(Request $request, $task_id)
    {
        try {

            $task = Task::where('id', '=', $task_id)->get()->first();
            $timelines = Timeline::where('task_id', $task->id)
                        ->join('users','timelines.user_id','=','users.id')
                        ->select('users.id AS user_id', 'timelines.id','users.email','task_updates','users.first_name','task_id', 'task_updates', 'timelines.updated_at', 'progress', 'timelines.notes')
                        ->orderBy('timelines.created_at', 'desc')
                        ->get();

            // dd($timelines);
            return view('admin.view_task', ['task' => $task, 'timelines' => $timelines]);
        } catch (\Throwable $th) {
            // dd($th);
            abort(500);
        }

        // dd($task, $timeline);

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
