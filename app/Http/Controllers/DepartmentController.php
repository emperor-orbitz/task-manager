<?php

namespace App\Http\Controllers;

use App\Department;
use App\User;
use App\Connection;
use App\Task;

use Illuminate\Http\Request;

class DepartmentController extends Controller
{

    public function index()
    {
        //

    }


    public function create(Request $request)
    {
        return view('admin.new_department');
    }


    public function store(Request $request)
    { //
        $department = new Department();
        $department->name = $request->input("name");
        $department->description = $request->input("description");
        $department->logo = " ";
        $department->status = true;
        $save = $department->save();
        if ($save) {
            $this->setStatus($request, ['status' => 'success', 'message' => "Department Created Successfully"]);
            return redirect()->back();
        } else {
            $this->setStatus($request, ['status' => 'error', 'message' => "Ooops! Something went wrong"]);
            return redirect()->back();
        }
    }


    public function show(Department $department, $id) //dept id
    {
        //fetch all department for admin
        $dept = $department->find($id);
        $members = Connection::where(['department_id' => $id])
            ->select('connections.id AS connection_id', 'users.first_name', 'users.last_name', 'users.email', 'connections.user_id', 'users.role')
            ->join('users', 'users.id', '=', 'connections.user_id')
            ->get();
        // dd($members);
        $non_members = User::select('first_name', 'last_name', 'id', 'email', 'role')
            ->where('role','<', '2')
            ->orderBy('role', 'desc')
            ->get();

        $tasks = $this->taskList($id);
        return view("admin.department", ['department' => $dept, 'members' => $members, 'non_members' => $non_members, 'tasks' => $tasks]);
    }

    
    public function showSupervisor(Department $department, $id) //dept id
    {
        //fetch all department for admin
        $dept = $department->find($id);
        $members = Connection::where(['department_id' => $id])
            ->select('connections.id AS connection_id', 'users.first_name', 'users.last_name', 'users.email', 'connections.user_id', 'users.role')
            ->join('users', 'users.id', '=', 'connections.user_id')
            ->get();
        // dd($members);
        $non_members = User::select('first_name', 'last_name', 'id', 'email', 'role')
            ->where('role','<', '2')
            ->orderBy('role', 'desc')
            ->get();

        $tasks = $this->taskList($id);
        return view("supervisor.department", ['department' => $dept, 'members' => $members, 'non_members' => $non_members, 'tasks' => $tasks]);
    }
    

    public function showUser(Department $department, $id) //dept id
    {
        //fetch all department for admin
        $dept = $department->find($id);
        $members = Connection::where(['department_id' => $id])
            ->select('connections.id AS connection_id', 'users.first_name', 'users.last_name', 'users.email', 'connections.user_id', 'users.role')
            ->join('users', 'users.id', '=', 'connections.user_id')
            ->get();
        // dd($members);
        $non_members = User::select('first_name', 'last_name', 'id', 'email', 'role')
            ->where('role','<', '2')
            ->orderBy('role', 'desc')
            ->get();

        $tasks = $this->taskList($id);
        return view("user.department", ['department' => $dept, 'members' => $members, 'non_members' => $non_members, 'tasks' => $tasks]);
    }
    

    public static function getAll()
    {
        //fetch all department for admin
        $all = Department::all();
        return $all;
    }


    public function edit(Request $request, Department $department)
    {
        //

    }

    public function taskList($id)
    {

        $tasks = Task::where('department_id', '=', $id)->get();
        return $tasks;
    }

    private function setStatus($request, $data)
    {

        $request->session()->flash('status', $data['status']);
        $request->session()->flash('message', $data['message']);
    }


    public function update(Request $request, Department $department)
    {
        //
        $id = $request->input('id');
        $data_input = $request->only(['name', 'description']);

        $update = $department->where('id', $id)->update($data_input);

        if ($update) {
            // dd($save);
            $this->setStatus($request, ['status' => 'success', 'message' => "Department Created Successfully"]);
            redirect()->back();
        } else {

            $this->setStatus($request, ['status' => 'error', 'message' => "Ooops! Something went wrong"]);
            redirect()->back();
        }
    }

 
    public function destroy(Department $department)
    {
        //
    }
}
