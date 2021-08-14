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
use Facade\FlareClient\Time\Time;

// use App\Http\Controllers\TaskController;

class SupervisorController extends Controller

{
    //
    public function dashboard(Request $request)
    {
        $results = Connection::getByUser(auth()->user()->id);
        // dd($results);

        
            // $departments = DepartmentController::getAll();
       
        $users = UserController::getAll()->sortByDesc('role');
        return view('supervisor.dashboard', ['departments' => $results, 'users' => $users]);
    }

    // public function deleteTask(Request $request, $id)
    // {
    //     //delete a task with its id
    //     $delete = Task::where('id', '=', $id)->delete();
    //     if ($delete) {
    //         self::setStatus($request, ['status' => 'success', 'message' => 'Task Deletion Successful']);
    //         return redirect()->back();
    //     } else {
    //         self::setStatus($request, ['status' => 'error', 'message' => 'Oops! I was unable to help you delete this']);
    //         return redirect()->back();
    //     }
    // }

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

    public function removeUserFromDepartment(Request $request, $connection_id)
    {
        try {
            $delete_connection =  Connection::where('id', '=', $connection_id)->delete();
            self::setStatus($request, ['status' => 'success', 'message' => 'User Successfully Removed']);
            return redirect()->back();
        } catch (\Throwable $e) {
            //    dd($e);
            self::setStatus($request, ['status' => 'error', 'message' => 'Oops! Unable to remove user']);
            return redirect()->back();
        }
    }

    // public function viewTask(Request $request, $task_id)
    // {
    //     try {

    //         $task = Task::where('id', '=', $task_id)->get()->first();
    //         $timelines = Timeline::where('task_id', $task->id)
    //                     ->join('users','timelines.user_id','=','users.id')
    //                     ->select('users.id AS user_id', 'timelines.id','users.email','task_updates','users.first_name','task_id', 'task_updates', 'timelines.updated_at', 'progress', 'timelines.notes')
    //                     ->orderBy('timelines.created_at', 'desc')
    //                     ->get();

    //         // dd($timelines);
    //         return view('supervisor.view_task', ['task' => $task, 'timelines' => $timelines]);
    //     } catch (\Throwable $th) {
    //         // dd($th);
    //         abort(500);
    //     }

    //     // dd($task, $timeline);

    // }


    
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

    

    public function createUser(Request $request)
    {

        $data = $request->only(['first_name', 'last_name', 'email', 'password', 'role']);
        if ($request->input('role') >= 2)
            return self::setStatusAndRedirect($request, ['status' => 'error', 'message' => 'Oops! I was unable to help you create this']);

        try {
            $create = User::create($data);
            if ($create) {
                return self::setStatusAndRedirect($request, ['status' => 'success', 'message' => 'User successfuly created by you']);
            }
        } catch (\Throwable $th) {
            //throw $th;
            return self::setStatusAndRedirect($request, ['status' => 'error', 'message' => 'Oops! Seems this email is taken']);
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
        return view('supervisor.new_user');
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
