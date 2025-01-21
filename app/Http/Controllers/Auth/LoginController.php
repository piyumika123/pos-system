<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Employee;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        Log::info('Login attempt for user: ' . $request->username);

        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            Log::info('Authentication successful for user: ' . $request->username);

            $user = Auth::user();
            Log::info('Authenticated user: ' . $user->user_name);

            $employee = Employee::where('user_name', $user->user_name)->first();
            if ($employee) {
                Log::info('Employee found: ' . $employee->user_name . ' with position ID: ' . $employee->position_id);

                switch ($employee->position_id) {
                    case 1:
                        return redirect()->intended('manager-dashboard');
                    case 2:
                        return redirect()->intended('warehouse-dashboard');
                    case 3:
                        return redirect()->intended('supermarket-dashboard');
                    default:
                        return redirect()->intended('dashboard');
                }
            }

            Log::warning('Employee not found for user: ' . $user->user_name);
            return redirect()->intended('dashboard');
        }

        Log::error('Login failed for user: ' . $request->username);

        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ])->withInput($request->only('username'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/login');
    }
}
?>
