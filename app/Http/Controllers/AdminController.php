<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Role;
use App\User;
use App\Video;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index()
    {
        return view('home', ['users' => User::all(), 'videos' => Video::all(), 'menu' => 'dashboard']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function manageAdmin()
    {
        $users = Admin::where('is_super', false)->get();

        return view('admin.index', ['users' => $users, 'menu' => 'manageAdmin']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     */
    public function create()
    {
        return view('admin.create', ['roles' => Role::all(), 'menu' => 'manageAdmin']);
    }

    /**
     * Show edit form.
     *
     * @return Factory|View
     */
    public function edit()
    {
        return view('admin.edit', ['menu' => 'admin']);
    }

    /**
     * Show edit form.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function changePassword(Request $request)
    {
        $admin = Admin::find(Auth::id());
        if (!Hash::check($request->old, $admin->password)) {
            return back()->withErrors('Invalid old password.');
        }

        if (Hash::check($request->password, $admin->password)) {
            return back()->withErrors('Your new password cannot be same as you existing password.');
        }

        $validate = Validator::make($request->all(), [
            'old' => 'required',
            'password' => 'required|confirmed|min:8',
        ]);

        if ($validate->fails()) return back()->withErrors($validate);

        $admin->password = Hash::make($request->password);
        $admin->save();

        return redirect()->route('admin.home');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {

        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'roles' => 'required|array',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8'
        ]);

        if ($validate->fails()) return back()->withErrors($validate)->withInput($request->except('password'));

        $user = Admin::firstOrCreate(
            ['name' => $request->name],
            [
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'is_super' => false
            ]
        );

        $user->roles()->sync($request->roles);

        return redirect()->route('admin.manage');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $user = Admin::find($id);
        $user->roles()->detach();

        Admin::destroy($id);

        return $this->successResponse();
    }
}
