<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Package;
use Spatie\Permission\Models\Role;
use App\Notifications\UserRegisterNotification;
use App\Notifications\SubscripNotification;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('id', 'ASC')->get();
        $package = Package::get();
        return view('admin.users.index', compact('users', 'package'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::select('id', 'name')->get();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate(
            $request,
            [
                'name' => 'string|required|max:30',
                'email' => 'string|required|unique:users',
                'password' => 'string|required',
                'role' => 'required',
                'status' => 'required|in:active,inactive',
                'profile_image' => 'nullable|string',
            ]
        );

        $data = $request->all();

        $data['password'] = Hash::make($request->password);

        $status = User::create($data);

        auth()->user()->notify(new UserRegisterNotification);
        $status->notify(new UserRegisterNotification);

        $status->assignRole($request->input('role'));
        // dd($status);
        if ($status) {
            request()->session()->flash('success', 'Successfully added user');
        } else {
            request()->session()->flash('error', 'Error occurred while adding user');
        }
        return redirect()->route('users.index');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::select('id', 'name')->get();
        return view('admin.users.edit', compact('roles'))->with('user', $user);
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
        $this->validate(
            $request,
            [
                'name' => 'string|required|max:30',
                'email' => 'string|required',
                // 'role'=>'required|in:admin,user',
                'status' => 'required|in:active,inactive',
                'photo' => 'nullable|string',
            ]
        );

        $data = $request->all();

        $user = User::find($id);
        $user->update($data);
        DB::table('model_has_roles')->where('model_id', $id)->delete();

        $user->assignRole($request->input('role'));


        $status = $user->fill($data)->save();
        if ($status) {
            request()->session()->flash('info', 'User Data Successfully updated');
        } else {
            request()->session()->flash('error', 'Error occured while updating');
        }
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $delete = User::findOrFail($id);
            $delete->delete();

            return response()->json(['success' => true, 'message' => 'Role deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to delete role.'], 500);
        }
    }
}
