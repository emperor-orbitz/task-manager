<?php

namespace App\Http\Controllers;

use App\Task;
use App\Connection;

use Illuminate\Http\Request;
use App\Http\Controllers\DepartmentController as Department;
use App\Timeline;

class TaskController extends Controller
{

    public function index()
    {
    }

    public function create()
    {
        //show create page here
        $departments = Department::getAll();
        return view('admin.new_task', ['departments' => $departments]);
    }


    public function supervisorCreate()
    {
        //show create page here
        $departments = Connection::where("user_id", "=", auth()->user()->id)
            ->join('departments', 'connections.department_id', '=', 'departments.id')
            ->get();
        // dd($departments);

        return view('supervisor.new_task', ['departments' => $departments]);
    }

    public function store(Request $request)
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
        // dd($request->input());
        //
        $updates = [
            'notes' => $request->input('notes'),
            'progress' => 100,
            'task_updates' => $request->input('task_updates'),
            'user_id' => auth()->user()->id,
            'task_id' => $request->input('task_id')
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

    public function show(Task $task)
    {
        //
    }

    public function edit(Task $task)
    {
        //
    }


    public function update(Request $request, Task $task)
    {
        //
    }


    public static function getAll(Request $request, Task $task)
    {
        //
        $all = Task::all();
        return $all;
    }
}
