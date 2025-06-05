<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('staff.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('staff')->attempt($credentials)) {
            $request->session()->regenerate();
            
            $staff = Auth::guard('staff')->user();
            $staff->update([
                'last_login_at' => now(),
                'last_login_ip' => $request->ip()
            ]);

            return $this->redirectToRoleDashboard($staff->role);
        }

        return back()->withErrors([
            'email' => 'Invalid credentials',
        ]);
    }

    protected function redirectToRoleDashboard($role)
    {
        return match($role) {
            'manager'     => redirect()->route('staff.manager.dashboard'),
            'operator'    => redirect()->route('staff.operator.dashboard'),
            'driver'      => redirect()->route('staff.driver.dashboard'),
            'subdriver'   => redirect()->route('staff.subdriver.dashboard'),
            'accountant'  => redirect()->route('staff.accountant.dashboard'),
            'dispatcher'  => redirect()->route('staff.dispatcher.dashboard'),
            default       => redirect()->route('staff.dashboard'),
        };
    }

    public function logout(Request $request)
    {
        Auth::guard('staff')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/staff/login');
    }
}