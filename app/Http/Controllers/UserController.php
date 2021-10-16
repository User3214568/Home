<?php

namespace App\Http\Controllers;

use App\Teacher;
use App\User;
use Facade\FlareClient\Stacktrace\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $content = 'user.index';
        $users = User::get();
        return view('admin', compact(['content', 'users']));
    }
    public function create()
    {
        $content = 'user.create';
        return view('admin', compact(['content']));
    }
    public function edit($id)
    {
        $user = User::find($id);
        if (isset($user)){
            if(Auth::user()->type == 0){
                $content = 'user.update';
                return view('admin', compact(['content', 'user']));
            }
            if(Auth::user()->type == 1){
                $content = 'parts.admin.user.user';
                return view('enseignant', compact(['content', 'user']));
            }
        }
    }
    public function store(Request $request)
    {
        if (Auth::user()->type == 0) {


            $is_valid = $request->validate([
                'first_name' => 'required |max:50',
                'last_name' => 'required |max:50',
                'cin' => 'required|unique:users|max:15',
                'email' => 'required|email|unique:users,email|max:30',
                'password' => 'required',
                'phone' => 'required|max:30'
            ]);
            if ($is_valid) {

                if ($request->file('image')) {
                    $file = $request->file('image');
                    $image = $request->cin . "." . $file->getClientOriginalExtension();
                    if (Storage::exists("app/avatars/$image")) {
                        Storage::delete("app/avatars/$image");
                    }
                    $file->storeAs('avatars', $image);
                } else {
                    $image = "default.jpg";
                }
                $pass_hashed = Hash::make($request->password);
                User::create(array_merge($request->only(['first_name', 'last_name', 'cin', 'email', 'phone']), ['password' => $pass_hashed, 'image' => $image]));
            }
            if (!isset($request->ajax))
                return redirect(route('user.create'));
        }
    }
    public function update($id, Request $request)
    {
        $user  =  User::find($id);
        if ($user) {

            $request->validate([
                'first_name' => 'required |max:50',
                'last_name' => 'required |max:50',
                'email' => 'required|max:30|email',
                'password' => 'required',
                'phone' => 'max:30'
            ]);

            if ($request->file('image')) {
                $file = $request->file('image');
                $image = $id . "." . $file->getClientOriginalExtension();
                if (Storage::exists("app/avatars/" . $user->image)) {
                    Storage::delete("app/avatars/" . $user->image);
                }
                $file->storeAs('avatars', $image);
            } else {
                $image = "default.jpg";
            }
            $user->update(array_merge($request->only(['first_name', 'last_name', 'email', 'phone']), ['password' => Hash::make($request->password), 'image' => $image]));

        }
        return redirect(route('user.index'));
    }
    public function login(Request $request)
    {
        $remeber = array_key_exists('remember_me', $request->all());
        $result = Auth::attempt($request->only(['email', 'password']), $remeber);
        if ($result) {
            if (Auth::user()->type == 0) {
                return redirect(route('admin'));
            } elseif (Auth::user()->type == 1) {
                return redirect(route('enseignant.index'));
            } else {
                return redirect('/');
            }
        } else {
            return view('login', ['alreadyFailed' => true]);
        }
    }
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
    public function destroy($id)
    {
        User::destroy($id);
        return redirect(route('user.index'));
    }
}
