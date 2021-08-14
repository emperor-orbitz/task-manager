<?php

namespace App\Http\Controllers;

use App\Task;
use App\Connection;
use App\User as UserModel;
use Illuminate\Http\Request;
use App\Http\Controllers\DepartmentController as Department;
use App\Timeline;
use App\Http\Controllers\UserController as User;
use App\TaskConnections;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{

    public function index()
    {
    }

    public function create()
    {
        //show create page here
        $departments = Department::getAll();
        $staffs = User::getAll();
        return view('admin.new_task', ['departments' => $departments, 'staffs' => $staffs]);
    }


    public function supervisorCreate()
    {
        //show create page here
        $departments = Connection::where("user_id", "=", auth()->user()->id)
            ->join('departments', 'connections.department_id', '=', 'departments.id')
            ->get();

        return view('supervisor.new_task', ['departments' => $departments]);
    }


    public function store(Request $request)
    {
        $data = [
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'assigner' => auth()->user()->id,
            'status' => true,
            'start' => $request->input('start'),
            'finish' => $request->input('finish'),
            'notes' => $request->input('notes')
        ];

        try {
            Task::create($data);
            $this->setStatus($request, ['status' => 'success', 'message' => 'Successfully added Task to Your Department list']);
            return redirect()->back();
        } catch (\Throwable $th) {
            //throw $th;
            $this->setStatus($request, ['status' => 'error', 'message' => 'Ooops! Something went wrong. We\'ll fix it']);
            return redirect()->back();
        }
    }


    public function supervisorStore(Request $request)
    {
        //
        $data = [
            'title' => $request->input('title'),
            'department_id' => $request->input('department_id'),
            'description' => $request->input('description'),
            'assigner' => auth()->user()->id,
            'status' => true,
            'start' => $request->input('start'),
            'finish' => $request->input('finish'),
            'notes' => $request->input('notes')
        ];
        $save = Task::create($data);
        if ($save) {
            $this->setStatus($request, ['status' => 'success', 'message' => 'Successfully added Task to Your Department list']);
            return redirect()->back();
        } else {
            $this->setStatus($request, ['status' => 'error', 'message' => 'Ooops! Something went wron. We\'ll fix it']);
            return redirect()->back();
        }
    }


    public static function viewTask(Request $request, $user_id)
    {

        $user = UserModel::get()->where('id', $user_id)->first();
        $taskConnections = TaskConnections::where('user_id', $user_id)
            ->join('tasks', 'task_connections.task_id', '=', 'tasks.id')
            ->select('task_connections.id', 'task_connections.task_id', 'tasks.title', 'tasks.description', 'tasks.created_at', 'tasks.progress', 'tasks.assigner', 'tasks.status', 'tasks.start', 'tasks.finish')
            ->get();

        // dd($taskConnections);
        $tasks = Task::get();
        return view('admin.assign_task', ['user' => $user, 'tasks' => $tasks, 'task_connections' => $taskConnections]);
    }


    public static function superviorViewTask(Request $request, $user_id)
    {

        $user = UserModel::get()->where('id', $user_id)->first();
        $taskConnections = TaskConnections::where('user_id', $user_id)
            ->join('tasks', 'task_connections.task_id', '=', 'tasks.id')
            ->select('task_connections.id', 'task_connections.task_id', 'tasks.title', 'tasks.description', 'tasks.created_at', 'tasks.progress', 'tasks.assigner', 'tasks.status', 'tasks.start', 'tasks.finish')
            ->get();

        // dd($taskConnections);
        $tasks = Task::get();
        return view('supervisor.assign_task', ['user' => $user, 'tasks' => $tasks, 'task_connections' => $taskConnections]);
    }

    public function addTaskToUser(Request $request)
    {
        try {

            $data = ['task_id' => $request->input('task_id'), 'user_id' => $request->input('user_id')];
            $checkRelationships = TaskConnections::where($data)->get()->first();
            if ($checkRelationships) {
                $this->setStatus($request, ['status' => 'error', 'message' => 'Ooops! This Staff already works on this task']);
                return redirect()->back();
            }
            TaskConnections::create($data);
            $this->setStatus($request, ['status' => 'success', 'message' => 'Successfully Added Task to User']);
            return redirect()->back();
        } catch (\Throwable $th) {
            //throw $th;
            abort(500, 'Unforsaken Error');
        }
    }

    public function adminEdit(Request $request)
    {
        //
        $id = $request->input('id');
        $updates = [
            'progress' => $request->input('progress'),
            'start' => $request->input('start'),
            'finish' => $request->input('finish'),
            'notes' => $request->input('notes')
        ];
        $update = Task::where('id', $id)->update($updates);

        if ($update) {
            $this->setStatus($request, ['status' => 'success', 'message' => 'Successfully Updated Task']);
            return redirect()->back();
        } else {
            $this->setStatus($request, ['status' => 'error', 'message' => 'Ooops! Something went wron. We\'ll fix it']);
            return redirect()->back();
        }
    }


    public function supervisorEdit(Request $request)
    {
        //
        $id = $request->input('id');
        $updates = [
            'progress' => $request->input('progress'),
            'start' => $request->input('start'),
            'finish' => $request->input('finish'),
            'notes' => $request->input('notes')
        ];
        $update = Task::where('id', $id)->update($updates);

        if ($update) {
            $this->setStatus($request, ['status' => 'success', 'message' => 'Successfully Updated Task']);
            return redirect()->back();
        } else {
            $this->setStatus($request, ['status' => 'error', 'message' => 'Ooops! Something went wron. We\'ll fix it']);
            return redirect()->back();
        }
    }




    public function userEdit(Request $request)
    {
        //
        $updates = [
            'notes' => $request->input('notes'),
            'progress' => 100,
            'task_updates' => $request->input('task_updates'),
            'task_connection_id'=>$request->input('task_connection_id')
         
        ];
        $create = Timeline::create($updates);

        if ($create) {
            $this->setStatus($request, ['status' => 'success', 'message' => 'Successfully Updated Task']);
            return redirect()->back();
        } else {
            $this->setStatus($request, ['status' => 'error', 'message' => 'Ooops! Something went wron. We\'ll fix it']);
            return redirect()->back();
        }
    }


    private function setStatus($request, $data)
    {

        $request->session()->flash('status', $data['status']);
        $request->session()->flash('message', $data['message']);
    }



    public static function getAll(Request $request, Task $task)
    {
        //
        $all = Task::all();
        return $all;
    }
}




















   // if(count($staff_id) > 0){
        //     try {
        //         DB::transaction(function () use($staff_id, $data){
        //             foreach($staff_id as $value){
        //                 $data['staff_id'] = $value;
        //                 Task::create($data);
        //             }
        //         });
        //         DB::commit();
                
        //     $this->setStatus($request, ['status' => 'success', 'message' => 'Successfully added Task to Your Department list']);
        //     return redirect()->back();
                
        //     } catch (\Throwable $th) {
        //         abort(500);

        //     }
            
        // }
        // else{
        //     $this->setStatus($request, ['status' => 'error', 'message' => 'Ooops! Something went wrong. We\'ll fix it']);
        //     return redirect()->back();
        // }