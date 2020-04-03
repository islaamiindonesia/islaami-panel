<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index()
    {
        $roles = Role::all();

        return view('role.index', ['roles' => $roles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     */
    public function create()
    {
        return view('role.create');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Factory|View
     */
    public function edit($id)
    {
        return view('role.edit', ['role' => Role::find($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
        ]);

        if ($validate->fails()) return back()->withErrors($validate)->withInput($request->all());

        Role::updateOrCreate(
            ['name' => $request->name],
            ['description' => $request->description]
        );

        return redirect()->route('admin.roles.manage');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $role = Role::find($id);
        $role->users()->detach();

        Role::destroy($id);

        return $this->successResponse();
    }
}
