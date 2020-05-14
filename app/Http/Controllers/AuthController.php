<?php

namespace App\Http\Controllers;

use App\Admin;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @return Factory|View
     */
    public function show()
    {
        return view('auth.login');
    }

    /**
     * Display the specified resource.
     *
     * @return Factory|RedirectResponse|View
     */
    public function login()
    {
        $credentials = ['email' => request('email'), 'password' => request('password')];

        $token = auth()->attempt($credentials);

        if (!$token) {
            if (!Admin::where("email", request('email'))->first()) {
                return back()->withErrors('Email not found');
            }
            return back()->withErrors('Invalid Password');
        }

        return redirect()->route('admin.home');
    }

    /**
     * Logout the specified User.
     *
     * @return RedirectResponse
     */
    public function logout()
    {
        auth()->logout();
        return redirect()->route('landingPage');
    }
}
