<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Factory|View
     */
    public function index(Request $request)
    {
        $selected = "active";
        $filter = $request->query('filter');
        $users = DB::table('users');
        if ($filter != null) {
            if ($filter == "active") {
                $users->whereNull('suspended_at');
            } else {
                $users->whereNotNull('suspended_at');
            }
            $selected = $filter;
        } else {
            $users->whereNull('suspended_at');
        }

        $users->whereNull('deleted_at');

        return view('user.index', ['users' => $users->get(), 'selected' => $selected, 'menu' => 'manageUser']);
    }

    /**
     * Suspend the specified user
     *
     * @param int $id
     * @return bool
     */
    public function suspend($id)
    {
        $user = User::find($id);
        $user->suspended_at = Carbon::now()->toDateTimeString();
        $user->save();

        return true;
    }

    /**
     * Unsuspend the specified user
     *
     * @param int $id
     * @return bool
     */
    public function unsuspend($id)
    {
        $user = User::find($id);
        $user->suspended_at = null;
        $user->save();

        return true;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return bool
     */
    public function softDelete($id)
    {
        User::where('id', $id)->delete();

        return true;
    }

    /**
     * Resote the specified resource from storage.
     *
     * @param int $id
     * @return bool
     */
    public function restoreUser($id)
    {
        User::where('id', $id)->restore();

        return true;
    }
}
