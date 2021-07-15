<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //
    public function registerUser(Request $request)
    {
        // dd("seen");
        $user = new User();
        $data = [
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ];

        try {
            //code...
            $create = $user::create($data);
            $this->setStatus($request, ['status' => 'success', 'message' => 'User created Successfully']);
            return redirect()->back();
        } catch (\Throwable $th) {
            //throw $th;
            $this->setStatus($request, ['status' => 'error', 'message' => 'Email Already in use']);
            return redirect()->back();
        }
    }


    public function loginUser(Request $request)
    {
        // $user = new User();

        $email = $request->input('email');
        $password = $request->input('password');

        $credentials = array('email' => $email, 'password' => $password);

        $attempt = Auth::attempt($credentials, true);

        if ($attempt) {

            return redirect()->route($this->chooseRole());
        } else {

            $this->setStatus($request, ['status' => 'error', 'message' => 'Invalid Email or Password']);
            return redirect()->back();
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

    /**
     * Sets Status Type and Message
     */
    private function setStatus($request, $data)
    {

        $request->session()->flash('status', $data['status']);
        $request->session()->flash('message', $data['message']);
    }

    private function chooseRole()
    {
        switch (auth()->user()->role) {
            case config('constants.options.IS_ADMIN'):
                return 'admin.dashboard';
            case config('constants.options.IS_DEPT'):
                return 'supervisor.dashboard';
            case config('constants.options.IS_USER'):
                return 'user.dashboard';
        }
    }

    public static function getAll()
    {
        $all = User::all();
        return $all;
    }
}
