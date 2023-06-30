<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\User;
use App\Models\UserStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with('status','department')->get();
        return response()->json($users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $status = UserStatus::select('id as value','name as label')->get();
        $department = Department::select('id as value','name as label')->get();
        return response()->json([
            'status' => $status,
            'department' => $department
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $request['avatar'];
        $request->validate([
            'status_id' => 'required',
            'username' => 'required|unique:users,username',
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
            'department_id' => 'required',
            'status_id' => 'required'
        ]);
        $fileName = '';
        // if($request['avatar']) {
        //     $image = $request['avatar'];
        //     $fileName = time() . '.' . $image->getClientOriginalName();
        //     $image->storeAs('public/images', $fileName);
        // }
        User::create([
            'status_id' => $request['status_id'],
            'username' => $request['username'],
            'name' => $request['name'],
            'email' => $request['email'],
            'department_id' => $request['department_id'],
            'password' => Hash::make($request['password']),
            'avatar' => $request['avatar']
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $status = UserStatus::select('id as value','name as label')->get();
        $department = Department::select('id as value','name as label')->get();
        return response()->json([
            'user' => $user,
            'status' => $status,
            'department' => $department
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'status_id' => 'required',
            'username' => 'required|unique:users,username,'.$id,
            'name' => 'required',
            'email' => 'required|email',
            'department_id' => 'required',
            'status_id' => 'required'
        ]);
        
        $user = User::find($id);
        $user->update([
            'status_id' => $request['status_id'],
            'username' => $request['username'],
            'name' => $request['name'],
            'email' => $request['email'],
            'department_id' => $request['department_id'],
            'password' => Hash::make($request['password']),
        ]);
        if($request['change_password'] == true) {
            $request->validate([    
                'password' => 'required|confirmed',
            ]);
            $user->update([
                'password' => Hash::make($request['password']),
                'change_password_at' => NOW()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $user = User::find($id);
        $user->delete();
    }
}
