<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Connection;
use App\Task;
use App\Timeline;


class MemberController extends Controller
{
    //
  
    public function dashboard(Request $request)
    {
        $results = Connection::getByUser(auth()->user()->id);
        // dd($results);
        $users = UserController::getAll()->sortByDesc('role');
        return view('user.dashboard', ['departments' => $results, 'users' => $users]);
    }

    public function deleteTask(Request $request, $id)
    {
        //delete a task with its id
        $delete = Task::where('id', '=', $id)->delete();
        if ($delete) {
            self::setStatusAndRedirect($request, ['status' => 'success', 'message' => 'Task Deletion Successful']);
            // return redirect()->back();
        } else {
            self::setStatusAndRedirect($request, ['status' => 'error', 'message' => 'Oops! I was unable to help you delete this']);
            // return redirect()->back();
        }
    }

    public function viewTask(Request $request, $task_id)
    {
        try {

            $task = Task::where('id', '=', $task_id)->get()->first();
            $timelines = Timeline::where(['task_id'=>$task->id, 'user_id'=>Auth::user()->id])
                        ->join('users','timelines.user_id','=','users.id')
                        ->select('users.id AS user_id', 'timelines.id','users.email','task_updates','users.first_name','task_id', 'task_updates', 'timelines.updated_at', 'progress', 'timelines.notes')
                        ->orderBy('timelines.created_at', 'desc')
                        ->get();

            // dd($timelines);
            return view('user.view_task', ['task' => $task, 'timelines' => $timelines]);
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
    /**
     * Sets Status Type and Message
     */
    private function setStatus($request, $data)
    {

        $request->session()->flash('status', $data['status']);
        $request->session()->flash('message', $data['message']);
    }


    public static function getAll()
    {
        $all = User::all();
        return $all;
    }
}
