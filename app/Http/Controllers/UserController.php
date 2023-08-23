<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Rules\CheckOldPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Str;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::with('roles')->where('id', '!=', 1)->paginate(25);
        return view("admin.users.index", compact('users', 'request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.users.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            "name" => "required|string",
            "avatar" => "nullable|mimes:image|max:1024",
            "email" => "required|string|unique:" . with(new User())->getTable() . ",email",
            'password' => 'min:6|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:6',
           // "mobile" => "nullable|numeric|unique:" . with(new User())->getTable() . ",mobile",
            "staff_id" => "nullable",
            "roles"    => "required|array",
            "roles.*"  => "required",
        ]);
        $data = $request->except('roles',  'avatar', 'password','mobile');
        if ($request->file('avatar')) {
            $avatar = time() . "_" . Str::random('20') . "." . $request->avatar->extension();
            $data['avatar'] = $request->avatar->storeAs('users', $avatar, 'public');
        }
        $data['password'] = Hash::make($request->password);
        try {
            DB::beginTransaction();
            $user = User::create($data);
            $user->assignRole($request->roles);
            DB::commit();
            return back()->with('success', 'It has been created.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('Somthing is wrong!', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function screen_lock(Request $request, $id)
    {
        Auth::logout();
        $user = User::find($id);
        return view('auth.pages.lock_screen', compact('user'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::with('roles')->where('id', $id)->first();
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::with("roles")->where('id', $id)->first();
        $roles = Role::where('id', '!=', 1)->get();
        return view("admin.users.edit", compact('user', 'roles'));
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
        $this->validate($request, [
            "name" => "required|string",
            "avatar" => "nullable|image",
            "email" => "required|email|unique:" . with(new User())->getTable() . ",email," . $id,
            "mobile" => "nullable|numeric|unique:" . with(new User())->getTable() . ",mobile," . $id,
            "staff_id" => "nullable",
            "roles"    => "required|array",
            "roles.*"  => "required",
        ]);
        $data = $request->except('roles', 'avatar', '_token', '_method');
        $user = User::with('roles')->where('id', $id)->first();
        if ($request->file('avatar')) {
            if ($user->avatar && file_exists(public_path(Storage::url($user->avatar)))) {
                Storage::disk('public')->delete($user->avatar);
            }
            $avatar = time() . "_" . Str::random('20') . "." . $request->avatar->extension();
            $data['avatar'] = $request->avatar->storeAs('users', $avatar, 'public');
        }
        try {
            DB::beginTransaction();
            $user->update($data);
            $roles = $request->input('roles');
            if (!empty($roles)) {
                if ($user->roles) {
                    $user->roles()->detach();
                }
                $user->syncRoles($roles);
            }
            DB::commit();
            return back()->with('success', 'It has been updated.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('Somthing is wrong!', $e->getMessage());
        }
    }
    /**
     * change user password the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function change_password($id)
    {
        return view("admin.users.change_password", compact('id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function password_update(Request $request, $id)
    {
        $this->validate($request, [
            'current_password' => ['required', new CheckOldPassword($id)],
            'new_password' => 'min:6|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:6',
        ]);
        $data['password'] = Hash::make($request->new_password);
        Auth::logoutOtherDevices($request->current_password);
        User::where('id', $id)->update($data);
        try {
            return back()->with('success', 'It has been updated.');
        } catch (\Exception $e) {
            return back()->with('Somthing is wrong!', $e->getMessage());
        }
    }


    /**
     * change status the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function status($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->update(['status' => ($user->status ? 0 : 1)]);
            return back()->with('success', 'It has been updated.');
        } catch (\Exception $e) {
            return back()->with('Somthing is wrong!', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
